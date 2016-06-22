<?php

/**
 * validate product data
 * @param array $data
 * @return bool
 */
function isValidProduct(array $data)
{
    if (!isset($data['name']) || !assert(is_string($data['name']) !== false)) {
        return false;
    }
    if (!isset($data['stock']) || !assert(is_numeric($data['stock']))) {
        return false;
    }
    return true;
}

/**
 * Gets product from data.
 * @param array $data
 * @return \Develop\Business\Product\Product Returns a formatted product.
 */
function getProductFromPost(array $data)
{
    return new \Develop\Business\Product\Product(
        $data['name'],
        $data['unit_price'],
        $data['stock'],
        (isset($data['id']) ? $data['id'] : null)
    );
}
