<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/models/wishlist.php';
require_once __DIR__ . '/../lib/dbconn.php';

$errormsg = null;
$successmsg = null;

if (isset($_POST['submit']) && isValidWishList($_POST['wish_item'])) {
    $wishItem = getWishList($_POST['wish_item']);
    if (addWishItem($wishItem)) {
        $successmsg = 'Product was added at wish list successfully!';
    } else {
        $errormsg = 'Product could not be added at wishlist! :(';
    }
}

if (isset($_GET['remove'])) {
    if (removeWishItem($_GET['remove'])) {
        header('Location: /wishlist.php?' . http_build_query(['email' => $_GET['email']]));
    } else {
        $errormsg = 'Product could not be removed from wishlist! :(';
    }
}

$wishlist = findAllWishProducts($_GET['email']);

include __DIR__ . '/../templates/wishlists/list.php';