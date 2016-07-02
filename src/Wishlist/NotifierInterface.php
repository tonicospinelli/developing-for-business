<?php

namespace Develop\Business\Wishlist;

interface NotifierInterface
{
    /**
     * @param Wishlist $wishlist
     * @return void
     */
    public function send(Wishlist $wishlist);
}
