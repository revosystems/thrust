<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\View\ComponentAttributeBag;

class Text extends Field
{
    protected $displayInIndexCallback = null;
    protected $editableHint           = false;
    protected $attributes             = [];
    protected $shouldAllowScripts     = false;
    protected $showAside              = null;
    protected ?string $icon           = null;

    public function editableHint($editableHint = true)
    {
        $this->editableHint = $editableHint;
        return $this;
    }

    public function getIndexClass()
    {
        return $this->editableHint ? 'editableHint' : '';
    }

    public function icon(?string $icon) : self
    {
        $this->icon = $icon;
        return $this;
    }

    public function displayWith($callback)
    {
        $this->displayInIndexCallback = $callback;
        return $this;
    }

    public function displayInIndex($object)
    {
        if ($this->displayInIndexCallback) {
            return call_user_func($this->displayInIndexCallback, $object);
        }
        return "<span class='{$this->getIndexClass()}'>{$this->getValue($object)}</span>";
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.input', [
            'inline'          => $inline,
            'title'           => $this->getTitle(),
            'type'            => $this->getFieldType(),
            'showAside'       => $this->showAside ?? $this->shouldShowAside(),
            'field'            => $this->field,
            'value'           => htmlspecialchars_decode($this->getValue($object)),
            'attributes'      => $this->getComponentBagAttributes($object),
            'description'     => $this->getDescription(),
            'icon'            => $this->icon,
            'learnMoreUrl'    => $this->learnMoreUrl,
        ])->render();
    }

    protected function getComponentBagAttributes($object) : ComponentAttributeBag {
        return new ComponentAttributeBag([
            ...$this->getHtmlValidation($object, $this->getFieldType()),
            ...$this->getFieldAttributes()
        ]);
    }

    protected function getFieldType()
    {
        return 'text';
    }

    public function showAside(bool $aside) : self{
        $this->showAside = $aside;
        return $this;
    }

    protected function shouldShowAside() : bool {
        return false;
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    protected function getFieldAttributes() : array
    {
        return $this->attributes;
    }

    public function getValue($object)
    {
        if (! $object) {
            return null;
        }

        $value = parent::getValue($object);
        
        return $value === null
            ? null
            : htmlspecialchars($value);
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
}
