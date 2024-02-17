<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\View\ComponentAttributeBag;

class Range extends Text
{
    protected $unit = '';
    protected $min  = 0;
    protected $max  = 300;
    protected $step = 5;

    public function unit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

    public function rangeAttributes($min, $max, $step)
    {
        $this->min  = $min;
        $this->max  = $max;
        $this->step = $step;
        return $this;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.range', [
            'inline'          => $inline,
            'title'           => $this->getTitle(),
            'type'            => $this->getFieldType(),
            'field'           => $this->field,
            'unit'            => $this->unit,
            'value'           => $this->getValue($object),
            'validationRules' => $this->getHtmlValidation($object, $this->getFieldType()),
            'attributes'      => $this->getComponentBagAttributes($object),
            'description'     => $this->getDescription(),
            'learnMoreUrl'    => $this->learnMoreUrl,
            'showAside'       => false,
        ])->render();
    }

    protected function getComponentBagAttributes($object) : ComponentAttributeBag {
        return new ComponentAttributeBag([
            'min' => $this->min,
            'max' => $this->max,
            'step' => $this->step,
            ...$this->attributes
        ]);
    }
}
