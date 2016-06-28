<?php

namespace Develop\Business\Wishlist\Tests\UseCases;

use Develop\Business\Wishlist\Exceptions\WishlistException;
use Develop\Business\Wishlist\Exceptions\WishlistNotFoundException;
use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\ItemResolver;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;
use Develop\Business\Wishlist\UseCases\AddItemWishlist;
use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\Intentions\AddItemWishlist as AddItemWishlistIntention;
use Develop\Business\Wishlist\Wishlist;
use Prophecy\Argument;

class AddItemWishlistTest extends \PHPUnit_Framework_TestCase
{
    public function testAddNewItemIntoWishlistSuccessful()
    {
        $email = 'email@test.com';
        $item = new Item(1, 'Shoes', false);

        $resolver = $this->prophesize(ItemResolver::class);
        $resolver->resolve(1)->willReturn($item);

        $intention = new AddItemWishlistIntention('email@test.com', 1);
        $factory = new WishlistFactory();
        $wishlist = $factory->newFromEmailAndItem($email, $item);

        $repository = $this->prophesize(WishlistRepository::class);
        $repository->findOneByEmailAndItem($email, $item)
            ->willThrow(WishlistException::notFoundByEmailAndWishlist($email, $item->getId()));
        $repository->add($wishlist)->willReturn($wishlist->setId(1));

        $useCase = new AddItemWishlist($repository->reveal(), $factory, $resolver->reveal());
        $wishlist = $useCase->execute($intention);

        $this->assertInstanceOf(Wishlist::class, $wishlist);
        $this->assertNotEmpty($wishlist->getId());
    }

    public function testAddNewItemIntoWishlistFailed()
    {
        $this->expectException(WishlistException::class);
        $this->expectExceptionMessage('The item(Shoes) already exists in your wish list');
        $email = 'email@test.com';
        $item = new Item(1, 'Shoes', false);

        $resolver = $this->prophesize(ItemResolver::class);
        $resolver->resolve(1)->willReturn($item);

        $intention = new AddItemWishlistIntention('email@test.com', 1);
        $factory = new WishlistFactory();
        $wishlist = $factory->newFromEmailAndItem($email, $item);

        $repository = $this->prophesize(WishlistRepository::class);
        $repository->findOneByEmailAndItem($email, $item)
            ->willReturn($wishlist);

        $useCase = new AddItemWishlist($repository->reveal(), $factory, $resolver->reveal());
        $useCase->execute($intention);
    }
}
