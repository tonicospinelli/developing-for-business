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
 * @return array Returns a formatted product.
 */
function getProductFromPost(array $data)
{
    return array(
        'id' => (isset($data['id']) ? $data['id'] : null),
        'name' => $data['name'],
        'unit_price' => $data['unit_price'],
        'stock' => $data['stock']
    );
}

/**
 * Find all products from database.
 * @return array
 */
function findAllProducts()
{
    $db = dbConnect();
    $stm = $db->prepare('SELECT * FROM products');
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Adds new product.
 * @param array $product
 * @return bool|int Returns a product ID when insert successful otherwise false.
 */
function addProduct(array $product)
{
    $db = dbConnect();
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO products (name, unit_price, stock) VALUES (?, ?, ?)');
        $stm->execute([$product['name'], $product['unit_price'], $product['stock']]);
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