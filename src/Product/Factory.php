<?php

namespace Develop\Business\Product;

use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Intentions\IdentifiedIntention;

class Factory
{
    public static function createFromIntention(Intention $intent)
    {
        return new Product($intent->getName(), $intent->getUnitPrice(), $intent->getStock());
    }

    public static function createFromIntentionIdentified(IdentifiedIntention $intent)
    {
        return new Product(
            $intent->getName(),
            $intent->getUnitPrice(),
            $intent->getStock(),
            $intent->getId()
        );
    }
}
