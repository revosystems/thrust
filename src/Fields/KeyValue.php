<?php

namespace BadChoice\Thrust\Fields;

class KeyValue extends Field
{
    public bool $showInEdit   = false;
    public $keyOptions   = null;
    public $valueOptions = null;
    public bool $searchable   = false;
    public bool $multiple     = false;
    public bool $fixed        = false;

    public function keyOptions($keyOptions) : self
    {
        $this->keyOptions = $keyOptions;
        return $this;
    }

    public function valueOptions($valueOptions) : self
    {
        $this->valueOptions = $valueOptions;
        return $this;
    }

    public function displayInIndex($object)
    {
        return '';
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.keyValue', [
            'title'         => $this->getTitle(),
            'inline'        => $inline,
            'field'         => $this->field,
            'keyValueField' => $this,
            'searchable'    => $this->searchable,
            'value'         => $this->getValue($object),
            'description'   => $this->getDescription(),
            'multiple'      => $this->multiple,
            'fixed'         => $this->fixed,
        ])->render();
    }

    public function multiple(bool $multiple = true) : self
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function searchable(bool $searchable = true) : self
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function fixedEntries(bool $fixed = true) : self
    {
        $this->fixed = $fixed;
        return $this;
    }

    public function generateOptions($array, $selected)
    {
        return collect($array)->map(function ($value, $key) use ($selected) {
            $selected = $this->isSelected($key, $selected) ? ' selected ' : '';
            return "<option value='$key' {$selected}>$value</option>";
        })->implode('');
    }

    protected function isSelected($key, $selected) : bool
    {
        return is_array($selected)
            ? in_array($key, $selected)
            : $key == $selected;
    }

    public function mapAttributeFromRequest($value)
    {
        return collect($value)->map(function ($entry) {
            if (! isset($entry['value'])) {
                $entry['value'] = null;
            }
            return $entry;
        });
    }
}
