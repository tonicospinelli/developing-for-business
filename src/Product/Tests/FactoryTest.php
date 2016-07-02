<?php

namespace Develop\Business\Product\Tests;

use Develop\Business\Product\Factory;
use Develop\Business\Product\Intentions\AddProduct;
use Develop\Business\Product\Product;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateProductFromIntention()
    {
        $factory = new Factory();
        $product = $factory->createFromIntention(new AddProduct('Shoes', 39.9, 10));

        $this->assertInstanceOf(Product::class, $product);
    }
}
