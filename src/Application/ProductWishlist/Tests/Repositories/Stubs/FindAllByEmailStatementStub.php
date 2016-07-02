<?php

namespace Develop\Business\Application\ProductWishlist\Tests\Repositories\Stubs;

use Develop\Business\Wishlist\Factory as WishlistFactory;
use Develop\Business\Wishlist\Factory;
use Develop\Business\Wishlist\Status;

class FindAllByEmailStatementStub extends \PDOStatement
{
    private $rows;

    /**
     * @var WishlistFactory
     */
    private $factory;

    /**
     * FindAllByEmailStatementStub constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public static function equalsTo($query)
    {
        return $query === 'SELECT
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
  wishlists.email = ?';
    }
    public function setFetchMode($mode, $params = null)
    {
    }

    public function execute($input_parameters = [])
    {
        $this->rows = [
            $this->factory->fromQueryResult(1, 'email@test.com', 1, 'Shoes', false, Status::PENDING)
        ];
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = [])
    {
        return $this->rows;
    }
}

