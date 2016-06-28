<?php

namespace Develop\Business\Wishlist\Tests\Intentions;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;
use Develop\Business\Wishlist\Intentions\AddItemWishlist;
use Develop\Business\Wishlist\Item;

class AddItemWishlistTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstanceSuccessful()
    {
        $intention = new AddItemWishlist('email@test.com', 1);

        $this->assertNotEmpty($intention->email);
        $this->assertNotEmpty($intention->itemId);
    }
}
