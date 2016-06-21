<?php

// load and initialize any global libraries
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../vendor/autoload.php';

// route the request internally
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/index.php/products' === $uri) {
    productListAction();
} elseif ('/index.php/products/add' === $uri && isset($_POST['product']) && isValidProduct($_POST['product'])) {
    productAddAction($_POST);
} elseif ('/index.php/products/remove' === $uri && isset($_GET['remove'])) {
    productRemoveAction($_GET['remove']);
} elseif ('/index.php/wishlist' === $uri && isset($_GET['email'])) {
    wishlistListAction($_GET['email']);
} elseif ('/index.php/wishlist/add' === $uri && isset($_GET['email']) && isset($_POST['submit']) && isValidWishList($_POST['wish_item'])) {
    wishlistAddAction($_GET['email'], $_POST);
} elseif ('/index.php/wishlist/remove' === $uri && isset($_GET['email']) && isset($_GET['remove'])) {
    wishlistRemoveAction($_GET['email'], $_GET['remove']);
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}