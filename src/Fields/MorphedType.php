<?php

namespace BadChoice\Thrust\Fields;

class MorphedType extends Text
{
    public $showInIndex = false;

    protected function getFieldType()
    {
        return 'hidden';
    }

    public function getValue($object)
    {
        $type = parent::getValue($object);
        return strlen($type) == 0 ? request('morphed') : $type;
    }

    public function displayInEdit($object, $inline = false)
    {
        return "<input type='hidden' name='{$this->field}_type' value='{$this->getValue($object)}'>";
    }
}
