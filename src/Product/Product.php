<?php

namespace Develop\Business\Product;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $unitPrice;

    /**
     * @var int
     */
    private $stock;

    /**
     * Product constructor.
     * @param string $name
     * @param float $unitPrice
     * @param int $stock
     * @param int|null $id
     */
    public function __construct($name, $unitPrice, $stock, $id = null)
    {
        $this->name = (string) $name;
        $this->unitPrice = (float) $unitPrice;
        $this->stock = (int) $stock;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param int $id
     * @return Product Returns a new object with given ID.
     */
    public function setId($id)
    {
        return new static($this->getName(), $this->getUnitPrice(), $this->getStock(), $id);
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

    public function merge(Product $product)
    {
        $callback = function ($value, $default = null) {
            if (!empty($value)) {
                return $value;
            }
            return $default;
        };
        return new static(
            $callback($product->getName(), $this->getName()),
            $callback($product->getUnitPrice(), $this->getUnitPrice()),
            $callback($product->getStock(), $this->getStock()),
            $this->getId()
        );
    }
}
