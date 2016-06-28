<?php

namespace Develop\Business\Application\ProductWishlist\Tests;

use Develop\Business\Application\ProductWishlist\ItemResolver;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Repositories\Product;
use Develop\Business\Wishlist\Exceptions\ItemResolvingException;
use Develop\Business\Wishlist\Item;

class ItemResolverTest extends \PHPUnit_Framework_TestCase
{
    public function testItemResolvedSuccessful()
    {
        $product = $this->prophesize(Product::class);
        $product->find(1)->willReturn(new \Develop\Business\Product\Product('Hat', 39.9, 10, 1));

        $resolver = new ItemResolver($product->reveal());
        $item = $resolver->resolve(1);

        $this->assertInstanceOf(Item::class, $item);
    }
    public function testItemResolvedFail()
    {
        $this->expectException(ItemResolvingException::class);
        $this->expectExceptionMessage('The requested product(1) was not found');

        $product = $this->prophesize(Product::class);
        $product->find(1)->willThrow(ProductNotFoundException::byIdentifier(1));

        $resolver = new ItemResolver($product->reveal());
        $resolver->resolve(1);
    }
}
