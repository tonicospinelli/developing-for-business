<?php

namespace Develop\Business\Product\Tests\Repositories\Stubs;

use Develop\Business\Product\Product;

class FindByNameStatementStub extends \PDOStatement
{
    /**
     * @var \ArrayIterator
     */
    private $rows;
    private $filter;

    public function setFetchMode($mode, $params = null)
    {
    }

    public function execute($input_parameters = [])
    {
        $this->filter = reset($input_parameters);
        $this->rows = new \ArrayIterator([new Product('Shoes', 69.9, 0, 1)]);
        $this->rows->rewind();

    }

    public function fetch($fetch_style = null, $fetch_argument = null, $ctor_args = [])
    {
        $filter = new \CallbackFilterIterator($this->rows, function(Product $product){
            return $product->getName() === $this->filter;
        });
        $filter->rewind();
        return $filter->current();
    }
}
