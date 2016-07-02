<?php

namespace Develop\Business\Product;

use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Intentions\IntentionIdentified;

class Factory
{
    public static function createFromIntention(Intention $intent)
    {
        return new Product($intent->getName(), $intent->getUnitPrice(), $intent->getStock());
    }

    public static function createFromIntentionIdentified(IntentionIdentified $intent)
    {
        return new Product(
            $intent->getName(),
            $intent->getUnitPrice(),
            $intent->getStock(),
            $intent->getId()
        );
    }
}
