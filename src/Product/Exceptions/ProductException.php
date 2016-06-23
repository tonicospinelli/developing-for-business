<?php

namespace Develop\Business\Product\Exceptions;

use Develop\Business\Product\Product;

class ProductException extends \Exception implements Exception
{
    /**
     * @param string $name
     * @return ProductExistsException
     */
    public static function existsWithName($name)
    {
        return ProductExistsException::withName($name);
    }

    public static function notAdded(Product $product)
    {
        return new static("The product({$product->getName()}) was not added.");
    }

    public static function notDeleted(Product $product)
    {
        return new static("The product({$product->getName()}) was not deleted.");
    }

    public static function notUpdated(Product $product)
    {
        return new static("The product({$product->getName()}) was not updated.");
    }
}
