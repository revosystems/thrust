<?php

namespace BadChoice\Thrust\Fields;

class Integer extends Decimal
{
    protected function getFieldAttributes() : array
    {
        return array_merge($this->attributes, ['step' => '1']);
    }
}
