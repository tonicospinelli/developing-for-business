<?php
namespace Develop\Business\Application\ProductWishlist;

use Develop\Business\Wishlist\NotifierInterface;
use Develop\Business\Wishlist\Wishlist;

final class EchoNotifier implements NotifierInterface
{
    public function send(Wishlist $wishlist)
    {
        echo "Email: {$wishlist->getEmail()}, Message: {$wishlist->getItemName()}" . PHP_EOL;
    }
}
