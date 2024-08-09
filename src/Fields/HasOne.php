<?php

namespace BadChoice\Thrust\Fields;

class HasOne extends Relationship
{
    public bool $showInEdit = false;

    public function displayInIndex($object)
    {
        return $this->getRelationName($object);
    }

    public function displayInEdit($object, $inline = false)
    {
    }
}
