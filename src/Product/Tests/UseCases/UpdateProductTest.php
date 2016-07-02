<?php

namespace Develop\Business\Product\Tests\UseCases;

use Develop\Business\Product\Events\ProductStockHasIncreased;
use Develop\Business\Product\Events\ProductWasUpdated;
use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\UpdateProduct as UpdateProductIntention;
use Develop\Business\Product\Product;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Product\UseCases\UpdateProduct;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateProductTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateAProductSuccessful()
    {
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->dispatch(ProductWasUpdated::NAME, Argument::type(ProductWasUpdated::class))->shouldBeCalled();
        $eventDispatcher->dispatch(ProductStockHasIncreased::NAME, Argument::type(ProductStockHasIncreased::class))->shouldBeCalled();

        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository->update(Argument::type(Product::class))->willReturn(new Product('T-Shirt', 33.9, 10, 1));

        $intention = new UpdateProductIntention(1, 'T-Shirt', 33.9, 100);

        $useCase = new UpdateProduct($repository->reveal(), new Factory(), $eventDispatcher->reveal());
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

        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);

        $repository = $this->prophesize(ProductRepository::class);
        $repository->find(1)->willReturn(new Product('T-Shirt', 33.9, 10, 1));
        $repository
            ->update(Argument::type(Product::class))
            ->willThrow(
                ProductException::notUpdated(new Product('T-Shirt', 33.9, 10, 1))
            );

        $intention = new UpdateProductIntention(1, 'Shoes', 33.9, 10);

        $useCase = new UpdateProduct($repository->reveal(), new Factory(), $eventDispatcher->reveal());
        $useCase->execute($intention);
    }
}
