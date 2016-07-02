<?php

namespace Develop\Business\Application\Product\Repositories;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;
use Develop\Business\Product\Repositories\Product as ProductRepository;

class Product implements ProductRepository
{
    /**
     * @var \PDO
     */
    private $driver;

    /**
     * Product constructor.
     * @param \PDO $driver
     */
    public function __construct(\PDO $driver)
    {
        $this->driver = $driver;
        $this->driver->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Prepare statement to map data into object.
     * @param \PDOStatement $statement
     */
    protected function prepareStatement(\PDOStatement $statement)
    {
        $statement->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            \Develop\Business\Product\Product::class,
            ['', 0.0, 0]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $stm = $this->driver->prepare('SELECT * FROM products WHERE id = ?');
        $this->prepareStatement($stm);
        $stm->execute([$id]);
        $product = $stm->fetch();

        if (!$product) {
            throw ProductNotFoundException::byIdentifier($id);
        }

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $stm = $this->driver->prepare('SELECT * FROM products');
        $this->prepareStatement($stm);
        $stm->execute();
        return $stm->fetchAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findByName($name)
    {
        $stm = $this->driver->prepare('SELECT * FROM products WHERE name LIKE ?');
        $this->prepareStatement($stm);
        $stm->execute([$name]);
        $product = $stm->fetch();

        if (!$product) {
            throw ProductNotFoundException::byName($name);
        }

        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function add(\Develop\Business\Product\Product $product)
    {
        $this->driver->beginTransaction();
        try {
            $stm = $this->driver->prepare('INSERT INTO products (name, unitPrice, stock) VALUES (?, ?, ?)');
            $stm->execute([$product->getName(), $product->getUnitPrice(), $product->getStock()]);
            $this->driver->commit();

            return $product->setId($this->driver->lastInsertId());
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }

        throw ProductException::notAdded($product);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(\Develop\Business\Product\Product $product)
    {
        $this->driver->beginTransaction();
        try {
            $stm = $this->driver->prepare('DELETE FROM products WHERE id = ?');
            $stm->execute([$product->getId()]);
            $this->driver->commit();
            return true;
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }
        throw ProductException::notDeleted($product);
    }

    /**
     * {@inheritdoc}
     */
    public function update(\Develop\Business\Product\Product $product)
    {
        $this->driver->beginTransaction();
        try {
            $stm = $this->driver->prepare('UPDATE products SET name = ?, unitPrice = ?, stock = ? WHERE id = ?');
            $stm->execute([$product->getName(), $product->getUnitPrice(), $product->getStock(), $product->getId()]);
            $this->driver->commit();

            return true;
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }

        throw ProductException::notUpdated($product);
    }
}
