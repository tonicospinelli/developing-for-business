<?php

namespace Develop\Business\Wishlist\Tests\UseCases;

use Develop\Business\Wishlist\Intentions\NotifyProductsAvailable as NotifyProductsAvailableIntention;
use Develop\Business\Wishlist\NotifierInterface;
use Develop\Business\Wishlist\Status;
use Develop\Business\Wishlist\UseCases\NotifyProductsAvailable;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;
use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\Wishlist;
use Prophecy\Argument;

class NotifyProductsAvailableTest extends \PHPUnit_Framework_TestCase
{
    public function testNotifyCustomerWhenProductIsAvailable()
    {
        $notifier = $this->prophesize(NotifierInterface::class);
        $notifier->send(Argument::type(Wishlist::class))->shouldBeCalled();

        $intention = new NotifyProductsAvailableIntention($notifier->reveal());
        $factory = new WishlistFactory();
        $wishlistPending = $factory->fromQueryResult(1, 'email@test.com', 1, 'T-Shirt', false, Status::PENDING);
        $wishlistSent = $factory->fromQueryResult(1, 'email@test.com', 1, 'T-Shirt', false, Status::SENT);

        $repository = $this->prophesize(WishlistRepository::class);
        $repository->findAllToNotify()
            ->willReturn([$wishlistPending]);
        $repository->update($wishlistSent)->willReturn(true);

        $useCase = new NotifyProductsAvailable($repository->reveal());
        $this->assertTrue($useCase->execute($intention));
    }
}
