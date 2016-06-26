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
     * @param $id
     * @param null $name
     * @param bool $available
     */
    public function __construct($id, $name = null, $available = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->available = (bool)$available;
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
