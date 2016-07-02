<?php

namespace Develop\Business\Product\Intentions;

interface Intention
{
    public function getName();

    public function getUnitPrice();

    public function getStock();
}
