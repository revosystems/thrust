<?php

namespace BadChoice\Thrust\Fields;

class Percentage extends Decimal
{
    protected ?string $icon = 'percentage';

    public function displayInIndex($object)
    {
        return $this->getValue($object) . ' %';
    }
}
