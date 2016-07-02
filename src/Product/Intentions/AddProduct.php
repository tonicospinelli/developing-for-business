<?php

namespace Develop\Business\Product\Intentions;

class AddProduct
{
    private $name;
    private $unitPrice;
    private $stock = 0;

    /**
     * @param string $name
     * @param float $unitPrice
     * @param int $stock
     */
    public function __construct($name, $unitPrice, $stock = 0)
    {
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }
}
