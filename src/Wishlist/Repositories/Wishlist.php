<?php

namespace Develop\Business\Wishlist\Repositories;

use Develop\Business\Wishlist\Exceptions\WishlistException;
use Develop\Business\Wishlist\Exceptions\WishlistNotFoundException;

interface Wishlist
{
    /**
     * @param \Develop\Business\Wishlist\Wishlist $wishlist
     * @return \Develop\Business\Wishlist\Wishlist Returns a new instance with id from database.
     * @throws WishlistException When is not possible to add record.
     */
    public function add(\Develop\Business\Wishlist\Wishlist $wishlist);

    /**
     * @param \Develop\Business\Wishlist\Wishlist $wishlist
     * @return \Develop\Business\Wishlist\Wishlist
     * @throws WishlistException When is not possible to delete record.
     */
    public function delete(\Develop\Business\Wishlist\Wishlist $wishlist);

    /**
     * @param \Develop\Business\Wishlist\Wishlist $wishlist
     * @return \Develop\Business\Wishlist\Wishlist
     * @throws WishlistException When is not possible to update record.
     */
    public function update(\Develop\Business\Wishlist\Wishlist $wishlist);

    /**
     * @param int $id
     * @return \Develop\Business\Wishlist\Wishlist
     * @throws WishlistNotFoundException
     */
    public function find($id);

    /**
     * @param string $email
     * @return \Develop\Business\Wishlist\Wishlist[] Returns all desired item from given email.
     */
    public function findAllByEmail($email);

    /**
     * @return \Develop\Business\Wishlist\Wishlist[] All desired items so that are available to notify the customer.
     */
    public function findAllToNotify();
}
