<?php

namespace Develop\Business\Product\Tests\Intentions;

use Develop\Business\Product\Intentions\DeleteProduct;

class DeleteProductTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateInstance()
    {
        $intention = new DeleteProduct(1);
        $this->assertNotEmpty($intention->getId());
    }
}
