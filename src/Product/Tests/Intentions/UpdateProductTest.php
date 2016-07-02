<?php

namespace Develop\Business\Product\Tests\Intentions;

use Develop\Business\Product\Intentions\UpdateProduct;

class UpdateProductTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $intention = new UpdateProduct(1, 'Shoes', 33.9, 10);
        $this->assertNotEmpty($intention->getId());
        $this->assertNotEmpty($intention->getName());
        $this->assertGreaterThan(0, $intention->getUnitPrice());
        $this->assertGreaterThan(0, $intention->getStock());
    }
}
