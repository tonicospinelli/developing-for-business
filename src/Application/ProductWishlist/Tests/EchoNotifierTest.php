<?php

namespace Develop\Business\Application\ProductWishlist\Tests;

use Develop\Business\Application\ProductWishlist\EchoNotifier;
use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\Wishlist;

class EchoNotifierTest extends \PHPUnit_Framework_TestCase
{
    public function testEchoSomeText()
    {
        $this->expectOutputString('Email: email@test.com, Message: T-Shirt' . PHP_EOL);
        $notifier = new EchoNotifier();
        $notifier->send(new Wishlist('email@test.com', new Item(1, 'T-Shirt')));
    }
}
