<?php

namespace Develop\Business\Wishlist;

class Item
{
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $available;

    /**
     * Item constructor.
     * @param int $id
     * @param string $name
     * @param bool $isAvailable
     */
    public function __construct($id, $name = null, $isAvailable = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->available = (bool)$isAvailable;
    }

    /**
     * @return mixed
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
     * @return bool
     */
    public function isAvailable()
    {
        return $this->available;
    }
}
