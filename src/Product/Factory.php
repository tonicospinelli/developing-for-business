<?php

namespace Develop\Business\Product;

use Develop\Business\Product\Intentions\AddProduct;

class Factory
{
    public function createFromArray(array $product)
    {
        return new Product(
            $product['name'],
            $product['unitPrice'],
            $product['stock'],
            (isset($product['id']) ? $product['id'] : null)
        );
    }

    public static function createFromIntention(AddProduct $intent)
    {
        return new Product($intent->getName(), $intent->getUnitPrice(), $intent->getStock());
    }
}
