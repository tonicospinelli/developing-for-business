<?php

namespace Develop\Business\Application\Wishlist\Tests\Repositories\Stubs;

use Develop\Business\Wishlist\Factory;
use Develop\Business\Wishlist\Status;
use Develop\Business\Wishlist\Wishlist;

class FindStatementStub extends \PDOStatement
{
    /**
     * @var array
     */
    private $rows;

    private $filter;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * FindOneByEmailAndItemIdStatementStub constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function setFetchMode($mode, $params = null)
    {
    }

    public static function equalsTo($statement)
    {
        return $statement === 'SELECT
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
  LIMIT 1';
    }

    public function execute($input_parameters = [])
    {
        $this->filter = reset($input_parameters);
        $this->rows = [
            $this->factory->createFromQueryResult(1, 'email@test.com', 1, 'Shoes', false, Status::PENDING)
        ];
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = [])
    {
        return array_filter($this->rows, function (Wishlist $wishlist) {
            return $wishlist->getId() === $this->filter;
        });
    }
}
