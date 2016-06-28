<?php

namespace Develop\Business\Wishlist\Exceptions;

use Develop\Business\Wishlist\Wishlist;

class WishlistException extends \Exception
{
    /**
     * @param Wishlist $wishlist
     * @return WishlistException
     */
    public static function notAdded(Wishlist $wishlist)
    {
        return new static("The item({$wishlist->getItemName()}) was not added into your wishlist.");
    }

    /**
     * @param Wishlist $wishlist
     * @return WishlistException
     */
    public static function notDeleted(Wishlist $wishlist)
    {
        return new static("The item({$wishlist->getItemName()}) was not delete from your wishlist.");
    }

    public static function notUpdated(Wishlist $wishlist)
    {
        return new static("The item({$wishlist->getItemName()}) was not updated from your wishlist.");
    }

    public static function notFoundByEmailAndWishlist($email, $itemId)
    {
        return WishlistNotFoundException::byEmailAndItemId($email, $itemId);
    }

    public static function notFoundById($id)
    {
        return WishlistNotFoundException::byId($id);
    }
}
