<?php

namespace Develop\Business\Wishlist\Exceptions;

class ItemResolvingException extends \Exception implements Exception
{
    public static function resquestedItemNotFound($identifier, $type = 'item')
    {
        return new static("The requested {$type}({$identifier}) was not found");
    }
}
