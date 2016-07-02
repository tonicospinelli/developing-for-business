<?php

namespace Develop\Business\Application\Product\Tests\Repositories\Stubs;

use Develop\Business\Product\Product;

class FindAllStatementStub extends \PDOStatement
{
    private $rows;

    public function setFetchMode($mode, $params = null)
    {
    }

    public function execute($input_parameters = [])
    {
        $this->rows = [
            new Product('Shoes', 69.9, 0, 1)
        ];
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = [])
    {
        return $this->rows;
    }
}

