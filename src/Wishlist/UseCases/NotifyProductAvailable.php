<?php

namespace Develop\Business\Wishlist\UseCases;

use Develop\Business\Wishlist\Intentions\NotifyProductAvailable as NotifyProductAvailableIntention;
use Develop\Business\Wishlist\ItemResolver;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;
use Develop\Business\Wishlist\Status;

class NotifyProductAvailable
{

    /**
     * @var WishlistRepository
     */
    private $repository;

    /**
     * @var ItemResolver
     */
    private $resolver;

    /**
     * NotifyProductsAvailable constructor.
     * @param WishlistRepository $repository
     * @param ItemResolver $resolver
     */
    public function __construct(WishlistRepository $repository, ItemResolver $resolver)
    {
        $this->repository = $repository;
        $this->resolver = $resolver;
    }

    /**
     * @param NotifyProductAvailableIntention $intention
     * @return bool
     */
    public function execute(NotifyProductAvailableIntention $intention)
    {
        $item = $this->resolver->resolve($intention->itemId);

        $wishlists = $this->repository->findAllCustomersByItem($item);

        foreach ($wishlists as $wishlist) {
            $intention->notifier->send($wishlist);
            $wishlist->changeStatusTo(Status::sent());
            $this->repository->update($wishlist);
        }
        return true;
    }
}
