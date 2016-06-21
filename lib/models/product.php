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

/**
 * Find all products from database.
 * @return \Develop\Business\Product\Product[] Returns a list of Products
 */
function findAllProducts()
{
    $db = dbConnect();
    $stm = $db->prepare('SELECT * FROM products');
    $stm->execute();
    return $stm->fetchAll(
        \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
        \Develop\Business\Product\Product::class,
        ['', 0.0, 0]
    );
}

/**
 * Adds new product.
 * @param \Develop\Business\Product\Product $product
 * @return bool|int Returns a product ID when insert successful otherwise false.
 */
function addProduct(\Develop\Business\Product\Product $product)
{
    $db = dbConnect();
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO products (name, unitPrice, stock) VALUES (?, ?, ?)');
        $stm->execute([$product->getName(), $product->getUnitPrice(), $product->getStock()]);
        $db->commit();
        return $db->lastInsertId();
    } catch (Exception $e) {
        $db->rollBack();
    }
    return false;
}

function removeProduct($id)
{
    $db = dbConnect();
    $db->beginTransaction();
    try {
        $stm = $db->prepare('DELETE FROM products WHERE id = ?');
        $stm->execute([$id]);
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
    }
    return false;
}