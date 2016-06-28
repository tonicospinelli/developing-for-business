<?php

namespace Develop\Business\Wishlist\Exceptions;

class WishlistNotFoundException extends \Exception
{
    /**
     * @param string $email
     * @param int $itemId
     * @return static
     */
    public static function byEmailAndItemId($email, $itemId)
    {
        return new static("The item was not found by email({$email}) and id({$itemId}) from your wishlist.");
    }

    public static function byId($id)
    {
        return new static("The wishlist was not found by id({$id})");
    }
}
