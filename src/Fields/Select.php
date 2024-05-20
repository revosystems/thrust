<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;

class Select extends Field
{
    protected array $options        = [];
    protected array$descriptions    = [];
    protected bool $allowNull       = false;
    protected bool $searchable      = false;
    protected bool $forceIntValue   = false;
    protected array $attributes     = [];
    protected bool $showAside       = false;
    protected ?string $icon         = null;

    public function options(array|Collection $options, bool $allowNull = false): static
    {
        $this->options = is_array($options)
            ? $options
            : $options->toArray();
        $this->allowNull = $allowNull;
        return $this;
    }

    public function optionDescriptions(array|Collection $descriptions): self
    {
        $this->descriptions = is_array($descriptions)
            ? $descriptions
            : $descriptions->all();
        return $this;
    }

    public function icon(?string $icon) : self
    {
        $this->icon = $icon;
        return $this;
    }

    public function forceIntValue(bool $forceIntValue = true): self
    {
        $this->forceIntValue = $forceIntValue;
        return $this;
    }

    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;
        return $this;
    }

    protected function getOptions(): array
    {
        if ($this->allowNull) {
            return ['' => '--'] + $this->options;
        }
        return $this->options;
    }

    public function allowNull(bool $allowNull = true): self
    {
        $this->allowNull = $allowNull;
        return $this;
    }

    public function showAside(bool $aside = true): self
    {
        $this->showAside = $aside;
        return $this;
    }

    public function displayInIndex($object)
    {
        if ($this->hasCategories()){
            $arrayWithoutCategories = collect($this->getOptions())->mapWithKeys(function($a) { return $a; })->all();
            return $arrayWithoutCategories[$this->getValue($object)] ?? '--';
        }
        return $this->getOptions()[$this->getValue($object)] ?? '--';
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.select', [
            'title'       => $this->getTitle(),
            'inline'      => $inline,
            'field'       => $this->field,
            'icon'       => $this->icon,
            'searchable'  => $this->searchable,
//            'value'       => intval($this->getValue($object)),
            'showAside'     => $this->showAside,
            'value'       => $this->getValue($object),
            'options'     => $this->getOptions(),
            'descriptions' => $this->descriptions,
            'description' => $this->getDescription(),
            'disabled'    => $this->attributes['disabled'] ?? false,
            'attributes'      => $this->getComponentBagAttributes($object),
            'hasCategories' => $this->hasCategories(),
            'learnMoreUrl'    => $this->learnMoreUrl,
        ])->render();
    }

    protected function getComponentBagAttributes($object): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getFieldAttributes());
    }

    public function getValue($object)
    {
        if ($this->forceIntValue) {
            return intval(parent::getValue($object));
        }
        return parent::getValue($object);
    }

    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    protected function getFieldAttributes(): array
    {
        return $this->attributes;
    }

    protected function hasCategories(): bool
    {
        $options = $this->getOptions();
        return is_array($options[array_key_first($options)] ?? null);
    }
}
