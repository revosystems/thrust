<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\View\ComponentAttributeBag;

class TextArea extends Field
{
    protected $attributes         = [];
    protected $shouldAllowScripts = false;

    public bool $showInIndex = false;

    public function displayInIndex($object)
    {
        return $this->getValue($object);
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.textarea', [
            'title'           => $this->getTitle(),
            'field'           => $this->field,
            'value'           => $this->getValue($object),
            'validationRules' => $this->getHtmlValidation($object, 'textarea'),
            'attributes'      => $this->getComponentBagAttributes($object),
            'description'     => $this->getDescription(),
        ])->render();
    }

    protected function getComponentBagAttributes($object) : ComponentAttributeBag {
        return new ComponentAttributeBag([
            ...$this->getHtmlValidation($object, 'textarea'),
            ...$this->attributes
        ]);
    }

    public function getValue($object)
    {
        return htmlspecialchars($object->{$this->field});
    }

    public function allowScripts()
    {
        $this->shouldAllowScripts = true;
        return $this;
    }

    public function mapAttributeFromRequest($value)
    {
        return parent::mapAttributeFromRequest(!$this->shouldAllowScripts ? strip_tags($value) : $value);
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
}
