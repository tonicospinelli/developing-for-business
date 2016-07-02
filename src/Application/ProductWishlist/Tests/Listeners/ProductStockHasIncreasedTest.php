<?php

namespace Develop\Business\Application\ProductWishlist\Tests\Listeners;

use Develop\Business\Application\ProductWishlist\Listeners\ProductStockHasIncreased;
use Develop\Business\Product\Events\ProductStockHasIncreased as ProductStockHasIncreasedEvent;
use Develop\Business\Wishlist\NotifierInterface;
use Develop\Business\Wishlist\UseCases\NotifyProductAvailable;
use Prophecy\Argument;

class ProductStockHasIncreasedTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldTriggerEvent()
    {
        $useCase = $this->prophesize(NotifyProductAvailable::class);
        $useCase->execute(Argument::type(\Develop\Business\Wishlist\Intentions\NotifyProductAvailable::class))->shouldBeCalled();

        $resolver = $this->prophesize(NotifierInterface::class);

        $listener = new ProductStockHasIncreased($useCase->reveal(), $resolver->reveal());
        $listener(new ProductStockHasIncreasedEvent(new \Develop\Business\Product\Product('Name', 39.9, 10, 1)));
    }
}
