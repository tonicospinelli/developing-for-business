<?php

use Develop\Business\Application\ProductWishlist\Repositories\PdoRepository as WishlistRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../vendor/autoload.php';

$factory = new WishlistFactory();
$repository = new WishlistRepository(dbConnect(), $factory);
$wishlists = $repository->findAllToNotify();

/** @var Develop\Business\Wishlist\Wishlist $wishlist */
foreach ($wishlists as $wishlist) {
    echo "sending email to {$wishlist->getEmail()} with {$wishlist->getItemName()}\n";
    $sentWishlist = $wishlist->changeStatusTo(\Develop\Business\Wishlist\Status::sent());
    $repository->update($sentWishlist);
}