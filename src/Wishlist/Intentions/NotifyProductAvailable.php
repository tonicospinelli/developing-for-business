<?php

namespace Develop\Business\Wishlist\Intentions;

use Develop\Business\Wishlist\Item;
use Develop\Business\Wishlist\NotifierInterface;

class NotifyProductAvailable
{
    /**
     * @var NotifierInterface
     */
    public $notifier;

    /**
     * @var int
     */
    public $itemId;

    /**
     * NotifyProductsAvailable constructor.
     * @param NotifierInterface $notifier
     */
    public function __construct(NotifierInterface $notifier, $itemId)
    {
        $this->notifier = $notifier;
        $this->itemId = $itemId;
    }
}
