<?php

namespace Develop\Business\Product\Tests\UseCases;

use Develop\Business\Product\Exceptions\ProductExistsException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\AddProduct as AddProductIntention;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Product\UseCases\AddProduct;
use Prophecy\Argument;

class AddProductTest extends \PHPUnit_Framework_TestCase
{
    public function testAddANewProductSuccessful()
    {
        $repository = $this->prophesize(ProductRepository::class);
        $repository->findByName('T-Shirt')->willThrow(ProductNotFoundException::byName('T-Shirt'));
        $repository->add(Argument::type(Product::class))->willReturn(new Product('T-Shirt', 33.9, 10, 1));

        $useCase = new AddProduct($repository->reveal(), new Factory());

        $intention = new AddProductIntention('T-Shirt', 33.9, 10);
        $product = $useCase->execute($intention);

        $this->assertEquals($intention->getName(), $product->getName());
        $this->assertEquals($intention->getUnitPrice(), $product->getUnitPrice());
        $this->assertEquals($intention->getStock(), $product->getStock());
        $this->assertNotEmpty($product->getId());
    }

    public function testAddANewProductFailed()
    {
        $this->expectException(ProductExistsException::class);
        $this->expectExceptionMessage('The product Shoes already exists');

        $repository = $this->prophesize(ProductRepository::class);
        $repository->findByName('Shoes')->willReturn(new Product('Shoes', 33.9, 10, 1));

        $useCase = new AddProduct($repository->reveal(), new Factory());

        $intention = new AddProductIntention('Shoes', 33.9, 10);
        $useCase->execute($intention);
    }
}
