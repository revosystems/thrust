<?php

namespace BadChoice\Thrust\Fields;

class Time extends Text
{
    protected bool $withSeconds;
    
    public function withSeconds(bool $withSeconds = true)
    {
        $this->withSeconds = $withSeconds;
        return $this;
    }

    protected function getFieldType()
    {
        return 'time';
    }

    protected function shouldShowAside(): bool
    {
        return true;
    }

    protected function getFieldAttributes() : array
    {
        return array_merge($this->attributes,
            $this->withSeconds ? ['step' => 1] : []
        );
    }
}
