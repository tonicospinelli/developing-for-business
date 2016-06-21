<?php

function wishlistListAction($email)
{
    $wishlist = findAllWishProducts($email);
    include TEMPLATE_DIR . '/wishlists/list.php';
}

function wishlistAddAction($email, $post)
{
    $wishItem = getWishList($post['wish_item']);
    if (addWishItem($wishItem)) {
        $successmsg = 'Product was added at wish list successfully!';
    } else {
        $errormsg = 'Product could not be added at wishlist! :(';
    }
    wishlistListAction($email);
}

function wishlistRemoveAction($email, $id)
{
    if (!removeWishItem($id)) {
        $errormsg = 'Product could not be removed from wishlist! :(';
    }
    header('Location: /index.php/wishlist?' . http_build_query(['email' => $_GET['email']]));

}