<?php

namespace Develop\Business\Wishlist\Intentions;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;
use Develop\Business\Wishlist\Item;

class AddItemWishlist
{
    public $email;

    /**
     * @var int
     */
    public $itemId;

    /**
     * AddItemWishlist constructor.
     * @param $email
     * @param int $itemId
     * @throws InvalidArgument
     */
    public function __construct($email, $itemId)
    {
        $this->email = $email;
        $this->itemId = $itemId;
    }
}