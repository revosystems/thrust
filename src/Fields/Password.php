<?php

namespace BadChoice\Thrust\Fields;

class Password extends Text
{
    public bool $showInIndex = false;
    protected ?string $icon = 'lock';

    public function displayInIndex($object)
    {
        return '******';
    }

    protected function getFieldType()
    {
        return 'password';
    }
}
