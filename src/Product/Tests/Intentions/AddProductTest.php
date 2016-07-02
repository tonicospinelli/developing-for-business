<?php

namespace Develop\Business\Product\Tests\Intentions;

use Develop\Business\Product\Intentions\AddProduct;

class AddProductTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $intention = new AddProduct('Shoes', 33.9, 10);
        $this->assertNotEmpty($intention->getName());
        $this->assertGreaterThan(0, $intention->getUnitPrice());
        $this->assertGreaterThan(0, $intention->getStock());
    }
}
