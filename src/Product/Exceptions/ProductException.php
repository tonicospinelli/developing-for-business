<?php

namespace Develop\Business\Product\Exceptions;

use Develop\Business\Exception;
use Develop\Business\Product\Product;

class ProductException extends Exception
{
    public static function exists($name)
    {
        return new static("The product {$name} already exists.");
    }

    public static function notAdded(Product $product)
    {
        return new static("The product {$product->getName()} was not added.");
    }

    public static function notFound($name)
    {
        return new static("The product {$name} was not found.");
    }

    public static function notDeleted(Product $product)
    {
        return new static("The product {$product->getName()} was not deleted.");
    }

    public static function notUpdated(Product $product)
    {
        return new static("The product {$product->getName()} was not updated.");
    }
}
