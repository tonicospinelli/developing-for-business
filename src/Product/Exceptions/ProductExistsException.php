<?php

namespace Develop\Business\Product\Exceptions;

class ProductExistsException extends \InvalidArgumentException implements Exception
{
    public static function withName($name)
    {
        return new static("The product {$name} already exists.");
    }
}
