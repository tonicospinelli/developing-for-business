<?php

namespace Develop\Business\Product\Events;

use Develop\Business\Product\Product;
use Symfony\Component\EventDispatcher\Event;

class ProductStockHasIncreased extends Event
{
    const NAME = 'product.stock.has.increased';

    /**
     * @var Product
     */
    private $product;

    /**
     * ProductWasUpdated constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
