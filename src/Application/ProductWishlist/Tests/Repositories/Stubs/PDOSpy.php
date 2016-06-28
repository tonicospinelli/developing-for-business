<?php

namespace Develop\Business\Application\ProductWishlist\Tests\Repositories\Stubs;

use Develop\Business\Wishlist\Factory as WishlistFacotry;

class PDOSpy extends \PDO
{
    public $commitCalled = false;

    public $rollBackCalled = false;

    public $beginTransactionCalled = false;

    public $setAttributeCalled = false;

    public $failureOnWrite = false;

    /**
     * @var WishlistFacotry
     */
    private $factory;

    public function __construct(WishlistFacotry $factory)
    {
        $this->factory = $factory;
    }

    public function setAttribute($attribute, $value)
    {
        $this->setAttributeCalled = true;
    }

    public function beginTransaction()
    {
        $this->beginTransactionCalled = true;
    }

    public function commit()
    {
        $this->commitCalled = true;
    }

    public function rollBack()
    {
        $this->rollBackCalled = true;
    }

    public function lastInsertId($name = null)
    {
        return 2;
    }

    public function prepare($statement, $options = null)
    {
        if (FindAllByEmailStatementStub::equalsTo($statement)) {
            return new FindAllByEmailStatementStub($this->factory);
        }

        if (FindStatementStub::equalsTo($statement)) {
            return new FindStatementStub($this->factory);
        }

        if (FindAllToNotifyStatementStub::equalsTo($statement)) {
            return new FindAllToNotifyStatementStub($this->factory);
        }

        if (FindOneByEmailAndItemIdStatementStub::equalsTo($statement)) {
            return new FindOneByEmailAndItemIdStatementStub($this->factory);
        }

        if ($statement == 'INSERT INTO wishlists (email, product_id, status) VALUES (?, ?, ?)') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        if ($statement == 'DELETE FROM wishlists WHERE id = ?') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        if ($statement == 'UPDATE wishlists SET status = ? WHERE email = ? AND product_id = ?') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        throw new \InvalidArgumentException('None Stub Statement was found for query: ' . $statement);
    }
}
