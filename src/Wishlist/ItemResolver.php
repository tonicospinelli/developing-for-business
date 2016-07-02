<?php

namespace Develop\Business\Wishlist;

use Develop\Business\Wishlist\Exceptions\ItemResolvingException;

interface ItemResolver
{
    /**
     * @param int $itemId
     * @return Item
     * @throws ItemResolvingException
     * @throws \Develop\Business\Product\Exceptions\ProductException
     */
    public function resolve($itemId);
}
