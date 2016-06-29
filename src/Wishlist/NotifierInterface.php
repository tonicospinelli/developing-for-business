<?php

namespace Develop\Business\Wishlist;

interface NotifierInterface
{
    public function send($email, $message);
}
