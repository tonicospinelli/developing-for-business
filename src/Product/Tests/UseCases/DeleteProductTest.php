<?php

namespace Develop\Business\Product\Tests\UseCases;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\DeleteProduct as DeleteProductIntention;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Product\Product;
use Develop\Business\Product\Tests\Repositories\Stubs\PDOSpy;
use Develop\Business\Product\UseCases\AddProduct;
use Develop\Business\Product\UseCases\DeleteProduct;
use Prophecy\Argument;

class DeleteProductTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleteAProductSuccessful()
    {
        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository->delete(Argument::type(Product::class))->willReturn(new Product('T-Shirt', 33.9, 10, 1));

        $intention = new DeleteProductIntention(1);

        $useCase = new DeleteProduct($repository->reveal(), new Factory());

        $product = $useCase->execute($intention);

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testDeleteAProductFailed()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('The product(T-Shirt) was not deleted');

        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository
            ->delete(Argument::type(Product::class))
            ->willThrow(ProductException::notDeleted(new Product('T-Shirt', 33.9, 10, 1)));

        $useCase = new DeleteProduct($repository->reveal(), new Factory());

        $intention = new DeleteProductIntention(1);
        $useCase->execute($intention);
    }
}
