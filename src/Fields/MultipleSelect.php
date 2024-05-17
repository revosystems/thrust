<?php

namespace BadChoice\Thrust\Fields;

class MultipleSelect extends Select
{
    protected $options    = [];
    protected bool $allowNull  = false;
    protected bool $searchable = false;
    protected bool $isMultiple = true;
    protected bool $clearable  = false;
    protected ?string $icon = null;

    public function displayInIndex($object): string
    {
        return collect($this->getValue($object))->map(function ($value) {
            return $this->getOptions()[$value];
        })->implode(', ');
    }

    public function icon(?string $icon) : self {
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
            'disabled'    => $this->attributes['disabled'] ?? false,
        ])->render();
    }

    public function mapAttributeFromRequest($value)
    {
        return array_filter($value);
    }

    public function clearable(bool $clearable = true): self
    {
        $this->clearable = $clearable;
        return $this;
    }
}
