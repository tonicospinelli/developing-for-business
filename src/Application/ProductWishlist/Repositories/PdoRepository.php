<?php

namespace Develop\Business\Application\ProductWishlist\Repositories;

use Develop\Business\Wishlist\Exceptions\WishlistException;
use Develop\Business\Wishlist\Exceptions\WishlistNotFoundException;
use Develop\Business\Wishlist\Factory;
use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\Repositories\Wishlist as WishlistRepository;
use Develop\Business\Wishlist\Wishlist;

class PdoRepository implements WishlistRepository
{
    /**
     * @var \PDO
     */
    private $driver;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * Product constructor.
     * @param \PDO $driver
     * @param Factory $factory
     */
    public function __construct(\PDO $driver, Factory $factory)
    {
        $this->driver = $driver;
        $this->driver->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->factory = $factory;
    }

    /**
     * @return \PDO
     */
    public function getDriver()
    {
        return $this->driver;
    }

    public function findAllByEmail($email)
    {
        $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  wishlists.email = ?
SQL;

        $stm = $this->driver->prepare($query);
        $stm->execute([$email]);
        return $stm->fetchAll(\PDO::FETCH_FUNC, [$this->factory, 'fromQueryResult']);
    }

    public function add(Wishlist $wishlist)
    {
        $this->driver->beginTransaction();
        try {
            $stm = $this->driver->prepare('INSERT INTO wishlists (email, product_id, status) VALUES (?, ?, ?)');
            $stm->execute([$wishlist->getEmail(), $wishlist->getItemId(), (string) $wishlist->getStatus()]);
            $this->driver->commit();

            return $wishlist->setId($this->driver->lastInsertId());
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }

        throw WishlistException::notAdded($wishlist);
    }

    public function delete(Wishlist $wishlist)
    {
        $this->driver->beginTransaction();
        try {
            $stm = $this->driver->prepare('DELETE FROM wishlists WHERE id = ?');
            $stm->execute([$wishlist->getId()]);
            $this->driver->commit();

            return $wishlist;
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }

        throw WishlistException::notDeleted($wishlist);
    }

    /**
     * @inheritdoc
     */
    public function findAllToNotify()
    {
        $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  products.stock > 0
  AND wishlists.status = 'P'
SQL;
        $stm = $this->driver->prepare($query);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_FUNC, [$this->factory, 'fromQueryResult']);
    }
    /**
     * @inheritdoc
     */
    public function findAllCustomersByItem(Item $item)
    {
        $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  wishlists.product_id = ?
  AND wishlists.status = 'P'
SQL;
        $stm = $this->driver->prepare($query);
        $stm->execute([$item->getId()]);
        return $stm->fetchAll(\PDO::FETCH_FUNC, [$this->factory, 'fromQueryResult']);
    }

    public function find($id)
    {
        $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  wishlists.id = ?
  LIMIT 1
SQL;

        $stm = $this->driver->prepare($query);
        $stm->execute([$id]);
        $retriveWishlist = $stm->fetchAll(\PDO::FETCH_FUNC, [$this->factory, 'fromQueryResult']);

        if (empty($retriveWishlist)) {
            throw WishlistException::notFoundById($id);
        }
        return reset($retriveWishlist);
    }

    public function update(Wishlist $wishlist)
    {
        $this->driver->beginTransaction();
        try {
            $query = 'UPDATE wishlists SET status = ? WHERE email = ? AND product_id = ?';

            $stm = $this->driver->prepare($query);
            $stm->execute([
                (string) $wishlist->getStatus(),
                $wishlist->getEmail(),
                $wishlist->getItemId()
            ]);
            $this->driver->commit();

            return true;
        } catch (\Exception $e) {
            $this->driver->rollBack();
        }

        throw WishlistException::notUpdated($wishlist);
    }

    /**
     * @param string $email
     * @param int $itemId
     * @return \Develop\Business\Wishlist\Wishlist
     * @throws WishlistNotFoundException
     */
    public function findOneByEmailAndItemId($email, $itemId)
    {
        $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  wishlists.email = ?
  AND wishlists.product_id = ?
LIMIT 1
SQL;
        $stm = $this->driver->prepare($query);
        $stm->execute([$email, $itemId]);
        $rows = $stm->fetchAll(\PDO::FETCH_FUNC, [$this->factory, 'fromQueryResult']);
        if (empty($rows)) {
            throw WishlistException::notFoundByEmailAndWishlist($email, $itemId);
        }
        return reset($rows);
    }

    public function findOneByEmailAndItem($email, Item $item)
    {
        return $this->findOneByEmailAndItemId($email, $item->getId());
    }
}