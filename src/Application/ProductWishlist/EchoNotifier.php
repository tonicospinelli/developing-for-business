<?php
namespace Develop\Business\Application\ProductWishlist;

use Develop\Business\Wishlist\NotifierInterface;

class EchoNotifier implements NotifierInterface
{
    public function send($email, $message)
    {
        echo "Email: {$email}, Message: {$message}" . PHP_EOL;
    }
}
