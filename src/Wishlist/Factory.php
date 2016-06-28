<?php

namespace Develop\Business\Wishlist;

class Factory
{
    /**
     * @param int $id
     * @param string $email
     * @param int $itemId
     * @param string $itemName
     * @param int $itemIsAvailable
     * @param string $status
     * @return Wishlist
     */
    public function createFromQueryResult($id, $email, $itemId, $itemName, $itemIsAvailable, $status)
    {
        $item = $this->createItem($itemId, $itemName, $itemIsAvailable);
        $status = $this->createStatus($status);
        return new Wishlist($email, $item, $status, $id);
    }

    /**
     * @param int $id
     * @param string $name
     * @param bool $isAvailable
     * @return Item
     */
    public function createItem($id, $name, $isAvailable)
    {
        return new Item($id, $name, $isAvailable);
    }

    /**
     * @param string $status
     * @return Status
     */
    public function createStatus($status)
    {
        return Status::create($status);
    }
}
