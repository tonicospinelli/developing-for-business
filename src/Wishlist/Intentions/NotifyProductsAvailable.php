<?php

namespace Develop\Business\Wishlist\Intentions;

use Develop\Business\Wishlist\NotifierInterface;

class NotifyProductsAvailable
{
    /**
     * @var NotifierInterface
     */
    private $notifier;

    /**
     * NotifyProductsAvailable constructor.
     * @param NotifierInterface $notifier
     */
    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    /**
     * @return NotifierInterface
     */
    public function getNotifier()
    {
        return $this->notifier;
    }
}
