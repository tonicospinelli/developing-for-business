<?php

namespace Develop\Business\Wishlist\Tests;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;
use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\Status;
use Develop\Business\Wishlist\Wishlist;

class WishlistTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstanceWithValidEmail()
    {
        $item = $this->prophesize(Item::class);
        $status = $this->prophesize(Status::class);
        $wishlist = new Wishlist('email@test.com', $item->reveal(), $status->reveal());

        $this->assertInstanceOf(Wishlist::class, $wishlist);
        $this->assertInstanceOf(Item::class, $wishlist->getItem());
        $this->assertNotEmpty($wishlist->getEmail());
        $this->assertEmpty($wishlist->getId());
    }

    public function testShouldCreateInstanceWithInvalidEmail()
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The email invalid@email is not valid');

        $item = $this->prophesize(Item::class);
        $status = $this->prophesize(Status::class);
        new Wishlist('invalid@email', $item->reveal(), $status->reveal());
    }

    public function testShouldCreateInstanceWithoutStatus()
    {
        $item = $this->prophesize(Item::class);
        $wishlist = new Wishlist('email@test.com', $item->reveal());

        $this->assertInstanceOf(Status::class, $wishlist->getStatus());
        $this->assertEquals(Status::pending(), $wishlist->getStatus());
    }

    public function testGetItemNameAndId()
    {
        $item = $this->prophesize(Item::class);
        $item->getName()->willReturn('Shoes');
        $item->getId()->willReturn(1);

        $status = $this->prophesize(Status::class);

        $wishlist = new Wishlist('email@test.com', $item->reveal(), $status->reveal());

        $this->assertEquals('Shoes', $wishlist->getItemName());
        $this->assertEquals(1, $wishlist->getItemId());
    }

    public function testItemFromWishListIsAvailable()
    {
        $item = $this->prophesize(Item::class);
        $item->isAvailable()->willReturn(true);

        $status = $this->prophesize(Status::class);

        $wishlist = new Wishlist('email@test.com', $item->reveal(), $status->reveal());

        $this->assertTrue($wishlist->isAvailable());
    }
}
