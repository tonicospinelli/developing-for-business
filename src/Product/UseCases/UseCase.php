<?php

namespace Develop\Business\Product\UseCases;

use Develop\Business\Product\Intentions\Intention;
use Develop\Business\Product\Product;

interface UseCase
{
    /**
     * @param Intention $intention
     * @return Product
     */
    public function execute(Intention $intention);
}
