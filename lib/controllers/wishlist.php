<?php

use Develop\Business\Application\ProductWishlist\Repositories\PdoRepository as WishlistRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;

function wishlistListAction($email)
{
    $db = dbConnect();
    $repository = new WishlistRepository($db, new WishlistFactory());
    $wishlist = $repository->findAllByEmail($email);
    include TEMPLATE_DIR . '/wishlists/list.php';
}

function wishlistAddAction(\Respect\Config\Container $container, $email, $post)
{
    try {
        $intention = getWishList($post['wish_item']);

        /** @var \Develop\Business\Wishlist\UseCases\AddItemWishlist $useCase */
        $useCase = $container->wishlistAddItemWishlistUseCase;
        $wishlist = $useCase->execute($intention);

        $successmsg = "Item({$wishlist->getItemName()}) was added at wish list successfully!";
    } catch (\Exception $e) {
        $errormsg = $e->getMessage();
    }

    $wishlist = $container->wishlistRepository->findAllByEmail($email);
    include TEMPLATE_DIR . '/wishlists/list.php';
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