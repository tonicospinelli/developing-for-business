<?php

namespace Develop\Business\Product\Exceptions;

class ProductNotFoundException extends \InvalidArgumentException implements Exception
{
    public static function byName($name)
    {
        return new static("The product({$name}) was not found.");
    }

    public static function byIdentifier($identifier)
    {
        return static::byName($identifier);
    }
}
