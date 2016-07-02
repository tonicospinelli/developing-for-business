<?php

namespace Develop\Business\Application\ProductWishlist;

use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Wishlist\Exceptions\ItemResolvingException;
use Develop\Business\Wishlist\Item;

class ItemResolver implements \Develop\Business\Wishlist\ItemResolver
{
    /**
     * @var ProductRepository
     */
    private $product;

    /**
     * ItemResolver constructor.
     * @param ProductRepository $product
     */
    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

    public function resolve($itemId)
    {
        try {
            $product = $this->product->find($itemId);
        } catch (ProductNotFoundException $e) {
            throw ItemResolvingException::resquestedItemNotFound($itemId, 'product');
        }

        return new Item($product->getId(), $product->getName(), $product->getStock() > 0);
    }
}
