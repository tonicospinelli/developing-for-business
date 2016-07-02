<?php

namespace Develop\Business\Application\ProductWishlist\Tests\Repositories;

use Develop\Business\Application\ProductWishlist\Repositories\PdoRepository;
use Develop\Business\Application\ProductWishlist\Tests\Repositories\Stubs\PDOSpy;
use Develop\Business\Wishlist\Exceptions\WishlistException;
use Develop\Business\Wishlist\Exceptions\WishlistNotFoundException;
use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\Status;
use Develop\Business\Wishlist\Wishlist;

class PdoRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WishlistFactory
     */
    private $factory;

    /**
     * @var PdoRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $this->factory = new WishlistFactory();

        $this->repository = new PdoRepository(new PDOSpy($this->factory), $this->factory);
    }

    public function testFindAllRecordsByEmail()
    {
        $wishlists = $this->repository->findAllByEmail('email@test.com');

        $this->assertCount(1, $wishlists);
        $this->assertInstanceOf(Wishlist::class, reset($wishlists));
    }

    public function testFindAllRecordsToNotify()
    {
        $wishlists = $this->repository->findAllToNotify();

        $this->assertCount(1, $wishlists);
        $this->assertInstanceOf(Wishlist::class, reset($wishlists));
    }

    public function testFindProductById()
    {
        $wishlist = $this->repository->find(1);

        $this->assertInstanceOf(Wishlist::class, $wishlist);
        $this->assertEquals(1, $wishlist->getId());
    }

    public function testFindAllCustomersByItem()
    {
        $wishlists = $this->repository->findAllCustomersByItem(new Item(1));

        $this->assertCount(1, $wishlists);
        $this->assertInstanceOf(Wishlist::class, reset($wishlists));
    }

    public function testNotFindRowById()
    {
        $this->expectException(WishlistNotFoundException::class);
        $this->expectExceptionMessage('The wishlist was not found by id(100)');

        $this->repository->find(100);
    }

    public function testAddNewRowSuccessful()
    {
        $wishlist = $this->factory->fromQueryResult(null, 'email@test.com', 1, 'Hat', false, Status::PENDING);

        $wishlistAdded = $this->repository->add($wishlist);

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();

        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);

        $this->assertInstanceOf(Wishlist::class, $wishlistAdded);
        $this->assertEquals('email@test.com', $wishlistAdded->getEmail());
        $this->assertEquals(2, $wishlistAdded->getId());
    }

    public function testAddNewRecordFailed()
    {
        $this->expectException(WishlistException::class);
        $this->expectExceptionMessage('The item(T-Shirt) was not added into your wishlist.');

        $wishlist = $this->factory->fromQueryResult(null, 'email@test.com', 1, 'T-Shirt', false, Status::PENDING);

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();
        $pdoSpy->failureOnWrite = true;

        $this->repository->add($wishlist);
    }

    public function testDeleteRowSuccessful()
    {
        $wishlist = $this->factory->fromQueryResult(1, 'email@test.com', 1, 'Hat', false, Status::PENDING);

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();

        $result = $this->repository->delete($wishlist);

        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);

        $this->assertEquals($wishlist, $result);
    }

    public function testDeleteRowFailed()
    {
        $this->expectException(WishlistException::class);
        $this->expectExceptionMessage('The item(Hat) was not delete from your wishlist.');

        $wishlist = $this->factory->fromQueryResult(1, 'email@test.com', 1, 'Hat', false, Status::PENDING);

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();
        $pdoSpy->failureOnWrite = true;

        $this->repository->delete($wishlist);
    }

    public function testUpdateRowSuccessful()
    {
        $wishlist = $this->factory->fromQueryResult(1, 'email@test.com', 1, 'Hat', false, Status::PENDING);

        $this->assertTrue($this->repository->update($wishlist));

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();
        $this->assertTrue($pdoSpy->beginTransactionCalled);
        $this->assertTrue($pdoSpy->commitCalled);
    }

    public function testUpdateProductFailed()
    {
        $this->expectException(WishlistException::class);
        $this->expectExceptionMessage('The item(Hat) was not updated from your wishlist.');

        $wishlist = $this->factory->fromQueryResult(1, 'email@test.com', 1, 'Hat', false, Status::PENDING);

        /** @var PDOSpy $pdoSpy */
        $pdoSpy = $this->repository->getDriver();
        $pdoSpy->failureOnWrite = true;

        $this->repository->update($wishlist);
    }

    public function testFindOneByEmailAndItemIdSuccessful()
    {
        $wishlist = $this->repository->findOneByEmailAndItemId('email@test.com', 1);

        $this->assertInstanceOf(Wishlist::class, $wishlist);
        $this->assertInstanceOf(Item::class, $wishlist->getItem());
    }

    public function testFindOneByEmailAndItemIdFailed()
    {
        $this->expectException(WishlistNotFoundException::class);
        $this->expectExceptionMessage('The item was not found by email(email@test.com) and itemId(2) from your wishlist.');

        $this->repository->findOneByEmailAndItemId('email@test.com', 2);
    }

    public function testFindOneByEmailAndItemSuccessful()
    {
        $wishlist = $this->repository->findOneByEmailAndItem('email@test.com', new Item(1));

        $this->assertInstanceOf(Wishlist::class, $wishlist);
        $this->assertInstanceOf(Item::class, $wishlist->getItem());
    }
}
