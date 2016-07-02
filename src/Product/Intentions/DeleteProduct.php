<?php

namespace Develop\Business\Product\Intentions;

class DeleteProduct implements IdentifiedIntention
{
    private $id;

    /**
     * UpdateProduct constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
