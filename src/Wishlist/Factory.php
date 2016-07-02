<?php

namespace Develop\Business\Wishlist;

class Factory
{
    /**
     * @param int $id
     * @param string $email
     * @param int $desiredItemId
     * @param string $desiredItemName
     * @param int $desiredItemStock
     * @param string $status
     * @return Wishlist
     */
    public function createFromQueryResult($id, $email, $desiredItemId, $desiredItemName, $desiredItemStock, $status)
    {
        return new Wishlist(
            $email,
            new Item($desiredItemId, $desiredItemName, $desiredItemStock),
            Status::create($status),
            $id
        );
    }
}
