<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/dbconn.php';

$errormsg = null;
$successmsg = null;

if (isset($_POST['submit']) && isValidProduct($_POST['product'])) {
    $product = getProduct($_POST['product']);
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO products (name, unit_price, stock) VALUES (?, ?, ?)');
        $stm->execute([$product['name'], $product['unit_price'], $product['stock']]);
        $db->commit();
        $successmsg = 'Product was saved successfully!';
    } catch (Exception $e) {
        $db->rollBack();
        $errormsg = 'Product could not be added! :(';
    }
}
$stm = $db->prepare('SELECT * FROM products');
$stm->execute();
$products = $stm->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../templates/products/list.php';