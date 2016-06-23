<?php

namespace Develop\Business\Product\Tests;

use Develop\Business\Product\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBeInstanciate()
    {
        $product = new Product('test', 99.9, 10);
        $this->assertEquals('test', $product->getName());
        $this->assertEquals(99.9, $product->getUnitPrice());
        $this->assertEquals(10, $product->getStock());
        $this->assertNull($product->getId());
    }

    public function testWhenIdDefinedShouldBeCreateOtherInstance()
    {
        $product = new Product('test', 99.9, 10);

        $this->assertNotEquals($product, $product->setId(1));
    }
}
