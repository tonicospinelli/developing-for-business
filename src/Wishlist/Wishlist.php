<?php

namespace Develop\Business\Wishlist;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;

class Wishlist
{
    private $id;

    private $email;

    /**
     * @var Item
     */
    private $item;

    /**
     * @var Status
     */
    private $status;

    /**
     * Wishlist constructor.
     * @param $email
     * @param Item $item
     * @param Status|null $status
     * @param int $id
     */
    public function __construct($email, Item $item, Status $status = null, $id = null)
    {
        $this->validate($email);
        $this->id = $id;
        $this->email = $email;
        $this->item = $item;

        if (null == $status) {
            $status = Status::pending();
        }

        $this->status = $status;
    }

    /**
     * @param $email
     * @throws InvalidArgument
     */
    protected function validate($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidArgument::invalidEmail($email);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Wishlist
     */
    public function setId($id)
    {
        return new static($this->getEmail(), $this->getItem(), $this->getStatus(), $id);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->item->getId();
    }

    /**
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return Wishlist
     */
    public function changeStatusTo(Status $status)
    {
        return new static($this->getEmail(), $this->getItem(), $status, $this->getId());
    }

    /**
     * @return string
     */
    public function getItemName()
    {
        return $this->item->getName();
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->item->isAvailable();
    }
}
