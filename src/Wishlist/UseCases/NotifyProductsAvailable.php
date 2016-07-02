<?php

namespace Develop\Business\Wishlist\UseCases;

use Develop\Business\Wishlist\Intentions\NotifyProductsAvailable as NotifyProductsAvailableIntention;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;
use Develop\Business\Wishlist\Status;

class NotifyProductsAvailable
{

    /**
     * @var WishlistRepository
     */
    private $repository;

    /**
     * NotifyProductsAvailable constructor.
     * @param WishlistRepository $repository
     */
    public function __construct(WishlistRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param NotifyProductsAvailableIntention $intention
     * @return bool
     */
    public function execute(NotifyProductsAvailableIntention $intention)
    {
        $wishlists = $this->repository->findAllToNotify();

        foreach ($wishlists as $wishlist) {
            $intention->getNotifier()->send($wishlist);
            $wishlist->changeStatusTo(Status::sent());
            $this->repository->update($wishlist);
        }
        return true;
    }
}
