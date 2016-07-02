<?php

namespace Develop\Business\Application\Product\Tests\Events;

use Develop\Business\Product\Events\ProductWasUpdated;
use Develop\Business\Product\Product;

class ProductWasUpdatedTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $product = $this->prophesize(Product::class);
        $event = new ProductWasUpdated($product->reveal());
        $this->assertInstanceOf(Product::class, $event->getProduct());
    }
}
