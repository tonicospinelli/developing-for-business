<?php

namespace Develop\Business\Wishlist\UseCases;

use Develop\Business\Wishlist\Exceptions\WishlistException;
use Develop\Business\Wishlist\Exceptions\WishlistNotFoundException;
use Develop\Business\Wishlist\Factory;
use Develop\Business\Wishlist\Intentions\AddItemWishlist as AddItemIntention;
use Develop\Business\Wishlist\ItemResolver;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;

class AddItemWishlist
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var WishlistRepository
     */
    private $repository;

    /**
     * @var ItemResolver
     */
    private $resolver;

    /**
     * AddWishlist constructor.
     * @param WishlistRepository $repository
     * @param Factory $factory
     * @param ItemResolver $resolver
     */
    public function __construct(
        WishlistRepository $repository,
        Factory $factory,
        ItemResolver $resolver
    ) {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->resolver = $resolver;
    }

    public function execute(AddItemIntention $intention)
    {
        $item = $this->resolver->resolve($intention->itemId);

        try {
            $wishlist = $this->repository->findOneByEmailAndItem($intention->email, $item);
            throw WishlistException::itemAlreadyInWishlist($wishlist);
        } catch (WishlistNotFoundException $e) {
            // do nothing
        }

        $wishlist = $this->factory->newFromEmailAndItem($intention->email, $item);

        return $this->repository->add($wishlist);
    }
}
