<?php

namespace Develop\Business\Product\Intentions;

interface IdentifiedIntention extends Intention
{
    public function getId();
}
