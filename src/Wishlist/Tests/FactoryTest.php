<?php

namespace Develop\Business\Wishlist\Tests;

use Develop\Business\Wishlist\Factory;
use Develop\Business\Wishlist\Wishlist;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateAWishlistObject()
    {
        $factory = new Factory();
        $wishlist = $factory->createFromQueryResult(1, 'email@test.com', 100, 'Shoes', false, 'P');

        $this->assertInstanceOf(Wishlist::class, $wishlist);
    }
}
