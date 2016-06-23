<?php

namespace Develop\Business\Product\Repositories;

use Develop\Business\Product\Exceptions\ProductException;
use Develop\Business\Product\Exceptions\ProductNotFoundException;

interface Product
{
    /**
     * @param int $id
     * @return \Develop\Business\Product\Product
     * @throws ProductNotFoundException
     */
    public function find($id);

    /**
     * @return \Develop\Business\Product\Product[]
     */
    public function findAll();

    /**
     * @param string $name
     * @return \Develop\Business\Product\Product
     * @throws ProductNotFoundException
     */
    public function findByName($name);

    /**
     * @param \Develop\Business\Product\Product $product
     * @return \Develop\Business\Product\Product
     * @throws ProductException
     */
    public function add(\Develop\Business\Product\Product $product);

    /**
     * @param \Develop\Business\Product\Product $product
     * @return \Develop\Business\Product\Product
     * @throws ProductException
     */
    public function delete(\Develop\Business\Product\Product $product);

    /**
     * @param \Develop\Business\Product\Product $product
     * @return bool
     * @throws ProductException
     */
    public function update(\Develop\Business\Product\Product $product);
}
