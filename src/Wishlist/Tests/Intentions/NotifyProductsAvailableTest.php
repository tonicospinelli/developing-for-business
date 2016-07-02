<?php

namespace Develop\Business\Wishlist\Tests\Intentions;

use Develop\Business\Wishlist\Intentions\NotifyProductsAvailable;
use Develop\Business\Wishlist\NotifierInterface;

class NotifyProductsAvailableTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstanceSuccessful()
    {
        $intention = new NotifyProductsAvailable(
            $this->prophesize(NotifierInterface::class)->reveal()
        );

        $this->assertInstanceOf(NotifierInterface::class, $intention->getNotifier());
    }

}
