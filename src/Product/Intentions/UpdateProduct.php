<?php

namespace Develop\Business\Product\Intentions;

class UpdateProduct implements IntentionIdentified
{
    private $id;

    private $name;

    private $unitPrice;

    private $stock = 0;

    /**
     * UpdateProduct constructor.
     * @param $id
     * @param $name
     * @param $unitPrice
     * @param int $stock
     */
    public function __construct($id, $name, $unitPrice, $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
