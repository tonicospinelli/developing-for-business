<?php

use Develop\Business\Application\ProductWishlist\ItemResolver;
use Develop\Business\Application\ProductWishlist\Repositories\PdoRepository as WishlistRepository;
use Develop\Business\Product\Repositories\Product as ProductRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\UseCases\AddItemWishlist as AddItemWishlistUseCase;

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
    $factory = new WishlistFactory();
    $repository = new WishlistRepository($db, $factory);
    $resolver = new ItemResolver(new ProductRepository($db));

    try {
        $intention = getWishList($post['wish_item']);

        $useCase = new AddItemWishlistUseCase($repository, $factory, $resolver);
        $wishlist = $useCase->execute($intention);

        $successmsg = "Item({$wishlist->getItemName()}) was added at wish list successfully!";
    } catch (\Exception $e) {
        $errormsg = $e->getMessage();
    }
    $wishlist = $repository->findAllByEmail($email);
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