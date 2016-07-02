<?php

namespace Develop\Business\Product\Tests;

use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\AddProduct;
use Develop\Business\Product\Intentions\UpdateProduct;
use Develop\Business\Product\Product;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateProductFromIdentifiedIntention()
    {
        $identifiedIntention = $this->prophesize(UpdateProduct::class);
        $identifiedIntention->getId()->willReturn(1);
        $identifiedIntention->getName()->willReturn('Shoes');
        $identifiedIntention->getUnitPrice()->willReturn(39.9);
        $identifiedIntention->getStock()->willReturn(10);

        $factory = new Factory();
        $product = $factory->createFromIntentionIdentified($identifiedIntention->reveal());

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testCreateProductFromIntention()
    {
        $factory = new Factory();
        $product = $factory->createFromIntention(new AddProduct('Shoes', 39.9, 10));

        $this->assertInstanceOf(Product::class, $product);
    }
}
