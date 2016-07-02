<?php

use Develop\Business\Application\ProductWishlist\Repositories\PdoRepository as WishlistRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\Intentions\NotifyProductsAvailable as NotifyProductsAvailableIntention;
use Develop\Business\Wishlist\UseCases\NotifyProductsAvailable as NotifyProductsAvailableUseCase;

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../vendor/autoload.php';

$factory = new WishlistFactory();
$repository = new WishlistRepository(dbConnect(), $factory);

$notifier = new \Develop\Business\Application\ProductWishlist\EchoNotifier();
$intention = new NotifyProductsAvailableIntention($notifier);

$useCase = new NotifyProductsAvailableUseCase($repository);
$useCase->execute($intention);
