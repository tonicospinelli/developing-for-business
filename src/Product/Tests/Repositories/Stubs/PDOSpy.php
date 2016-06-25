<?php

namespace Develop\Business\Product\Tests\Repositories\Stubs;

class PDOSpy extends \PDO
{
    public $commitCalled = false;
    public $rollBackCalled = false;
    public $beginTransactionCalled = false;
    public $setAttributeCalled = false;
    public $failureOnWrite = false;

    public function __construct()
    {
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
        if ($statement == 'SELECT * FROM products') {
            return new FindAllStatementStub();
        }

        if ($statement == 'SELECT * FROM products WHERE name LIKE ?') {
            return new FindByNameStatementStub();
        }

        if ($statement == 'SELECT * FROM products WHERE id = ?') {
            return new FindStatementStub();
        }

        if ($statement == 'INSERT INTO products (name, unitPrice, stock) VALUES (?, ?, ?)') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        if ($statement == 'DELETE FROM products WHERE id = ?') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        if ($statement == 'UPDATE products SET name = ?, unitPrice = ?, stock = ? WHERE id = ?') {
            return ($this->failureOnWrite ? new WriteFailureStatementStub() : new WriteSuccessStatementStub());
        }

        throw new \InvalidArgumentException('None Stub Statement was found for query: ' . $statement);
    }
}
