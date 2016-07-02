<?php

namespace Develop\Business\Wishlist\Tests;

use Develop\Business\Wishlist\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $item = new Item(1, 'Shoes', false);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertNotEmpty($item->getId());
        $this->assertNotEmpty($item->getName());
        $this->assertFalse($item->isAvailable());
    }
}
