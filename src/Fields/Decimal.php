<?php

namespace BadChoice\Thrust\Fields;

class Decimal extends Text
{
    protected bool $asInteger = false;
    protected bool $nullable = false;
    public string $rowClass = 'text-right';

    public function getValue($object)
    {
        $value = parent::getValue($object);
        if ($value === null & $this->nullable) {
            return null;
        }
        if ($value && $this->asInteger) {
            return number_format(floatval($value) / 100.0, 2);
        }
        return floatval($value);
    }

    public function mapAttributeFromRequest($value)
    {
        if ($this->asInteger) {
            return $value * 100.0;
        }
        return $value;
    }

    public function asInteger($asInteger = true)
    {
        $this->asInteger = $asInteger;
        return $this;
    }

    public function nullable($nullable = true)
    {
        $this->nullable = $nullable;
        return $this;
    }

    protected function getFieldType()
    {
        return 'number';
    }

    protected function shouldShowAside(): bool
    {
        return true;
    }

    protected function getFieldAttributes() : array
    {
        return array_merge($this->attributes, ['step' => 'any']);
    }

}
