<?php

namespace BadChoice\Thrust\Fields;

class Url extends Text
{
    protected ?string $icon = 'link';

    public function displayInIndex($object)
    {
        $value = $this->getValue($object);
        return "<a href='$value'>$value</a>";
    }

    protected function getFieldType()
    {
        return 'url';
    }
}
