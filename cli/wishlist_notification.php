<?php

require_once __DIR__ . '/../lib/functions.php';
require_once __DIR__ . '/../lib/models/wishlist.php';
require_once __DIR__ . '/../lib/dbconn.php';

$wishlists = findAllWishlistsToNotify();

foreach ($wishlists as $wishlist) {
    echo "sending email to {$wishlist['email']} with {$wishlist['product_name']}\n";
    wishlistNotified($wishlist['id']);
}