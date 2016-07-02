<?php

namespace Develop\Business\Product\Tests\UseCases;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\UpdateProduct as UpdateProductIntention;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Product\UseCases\UpdateProduct;
use Prophecy\Argument;

class UpdateProductTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateAProductSuccessful()
    {
        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository->update(Argument::type(Product::class))->willReturn(new Product('T-Shirt', 33.9, 10, 1));

        $intention = new UpdateProductIntention(1, 'T-Shirt', 33.9, 100);

        $useCase = new UpdateProduct($repository->reveal(), new Factory());
        $product = $useCase->execute($intention);

        $this->assertEquals($intention->getName(), $product->getName());
        $this->assertEquals($intention->getUnitPrice(), $product->getUnitPrice());
        $this->assertEquals($intention->getStock(), $product->getStock());
        $this->assertNotEmpty($product->getId());
    }

    public function testUpdateAProductFailed()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('The product(T-Shirt) was not updated');

        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository
            ->update(Argument::type(Product::class))
            ->willThrow(
                ProductException::notUpdated(new Product('T-Shirt', 33.9, 10, 1))
            );

        $intention = new UpdateProductIntention(1, 'Shoes', 33.9, 10);

        $useCase = new UpdateProduct($repository->reveal(), new Factory());
        $useCase->execute($intention);
    }
}
