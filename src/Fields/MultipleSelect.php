<?php

namespace BadChoice\Thrust\Fields;

class MultipleSelect extends Select
{
    protected array $options    = [];
    protected bool $allowNull  = false;
    protected bool $searchable = false;
    protected bool $isMultiple = true;
    protected bool $clearable  = false;
    protected ?string $icon = null;

    public function displayInIndex($object): string
    {
        return collect($this->getValue($object))->map(
            fn($value) => $this->getOptions()[$value])->implode(', ');
    }

    public function icon(?string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.multipleSelect', [
            'title'       => $this->getTitle(),
            'inline'      => $inline,
            'field'       => $this->field,
            'icon'       => $this->icon,
            'searchable'  => $this->searchable,
            'value'       => $this->getValue($object),
            'options'     => $this->getOptions(),
            'description' => $this->getDescription(),
            'clearable'   => $this->clearable,
            'showAside'   => false,
            'learnMoreUrl'=> $this->learnMoreUrl,
            'attributes'  => $this->getComponentBagAttributes($object),
        ])->render();
    }

    public function mapAttributeFromRequest($value)
    {
        return array_filter($value, fn(mixed $val) => !is_null($val) && $val !== '');
    }

    public function clearable(bool $clearable = true): static
    {
        $this->clearable = $clearable;
        return $this;
    }
}
