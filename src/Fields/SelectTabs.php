<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\Support\Collection;

class SelectTabs extends Field
{
    protected $options          = [];
    protected bool $forceIntValue    = false;
    protected $showAside = false;

    public function options(array|Collection $options)
    {
        $this->options = is_array($options)
            ? $options
            : $options->toArray();
        return $this;
    }

    public function forceIntValue(bool $forceIntValue = true): self
    {
        $this->forceIntValue = $forceIntValue;
        return $this;
    }

    protected function getOptions()
    {
        return $this->options;
    }

    public function showAside(bool $aside = true) :self
    {
        $this->showAside = $aside;
        return $this;
    }

    public function displayInIndex($object)
    {
        return $this->getOptions()[$this->getValue($object)] ?? '--';
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.select-tabs', [
            'title'       => $this->getTitle(),
            'inline'      => $inline,
            'field'       => $this->field,
            'showAside'     => $this->showAside,
            'value'       => $this->getValue($object),
            'options'     => $this->getOptions(),
            'description' => $this->getDescription(),
            'learnMoreUrl'    => $this->learnMoreUrl,
        ])->render();
    }

    public function getValue($object)
    {
        if ($this->forceIntValue) {
            return intval(parent::getValue($object));
        }
        return parent::getValue($object);
    }

}
