<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/dbconn.php';
require_once __DIR__ . '/../lib/models/product.php';

$errormsg = null;
$successmsg = null;

if (isset($_POST['submit']) && isValidProduct($_POST['product'])) {
    $product = getProductFromPost($_POST['product']);
    if (addProduct($product)) {
        $successmsg = 'Product was saved successfully!';
    } else {
        $errormsg = 'Product could not be added! :(';
    }
}

$products = findAllProducts();

include __DIR__ . '/../templates/products/list.php';
