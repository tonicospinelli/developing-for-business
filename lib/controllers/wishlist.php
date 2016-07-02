<?php

use Develop\Business\Application\Wishlist\Repositories\PdoRepository as WishlistRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;

function wishlistListAction($email)
{
    $db = dbConnect();
    $repository = new WishlistRepository($db, new WishlistFactory());
    $wishlist = $repository->findAllByEmail($email);
    include TEMPLATE_DIR . '/wishlists/list.php';
}

function wishlistAddAction($email, $post)
{
    $db = dbConnect();
    $repository = new WishlistRepository($db, new WishlistFactory());
    $wishItem = getWishList($post['wish_item']);
    if ($repository->add($wishItem)) {
        $successmsg = 'Product was added at wish list successfully!';
    } else {
        $errormsg = 'Product could not be added at wishlist! :(';
    }
    wishlistListAction($email);
}

function wishlistRemoveAction($email, $id)
{
    $db = dbConnect();
    $repository = new WishlistRepository($db, new WishlistFactory());

    $wishlist = $repository->find($id);
    if (!$repository->delete($wishlist)) {
        $errormsg = 'Product could not be removed from wishlist! :(';
    }
    header('Location: /index.php/wishlist?' . http_build_query(['email' => $_GET['email']]));

}