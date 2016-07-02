<?php

namespace Develop\Business\Application\ProductWishlist\Listeners;

use Develop\Business\Product\Events\ProductStockHasIncreased as ProductStockHasIncreasedEvent;
use Develop\Business\Wishlist\Intentions\NotifyProductAvailable as NotifyProductAvailableIntention;
use Develop\Business\Wishlist\NotifierInterface;
use Develop\Business\Wishlist\UseCases\NotifyProductAvailable;

class ProductStockHasIncreased
{
    /**
     * @var NotifyProductAvailable
     */
    private $useCase;

    /**
     * @var NotifierInterface
     */
    private $notifier;

    /**
     * Product constructor.
     * @param NotifyProductAvailable $useCase
     * @param NotifierInterface $notifier
     */
    public function __construct(NotifyProductAvailable $useCase, NotifierInterface $notifier)
    {
        $this->useCase = $useCase;
        $this->notifier = $notifier;
    }

    public function __invoke(ProductStockHasIncreasedEvent $event)
    {
        $intention = new NotifyProductAvailableIntention($this->notifier, $event->getProduct()->getId());
        $this->useCase->execute($intention);
    }
}
