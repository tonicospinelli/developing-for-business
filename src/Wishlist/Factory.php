<?php

namespace Develop\Business\Wishlist;

use Develop\Business\Wishlist\Intentions\AddItemWishlist as AddItemWishlistIntention;

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
    public function fromQueryResult($id, $email, $itemId, $itemName, $itemIsAvailable, $status)
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

    public function newFromEmailAndItem($email, Item $item)
    {
        return $this->fromQueryResult(
            null,
            $email,
            $item->getId(),
            $item->getName(),
            $item->isAvailable(),
            Status::PENDING
        );
    }
}
