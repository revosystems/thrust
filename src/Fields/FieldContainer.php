<?php

namespace BadChoice\Thrust\Fields;

abstract class FieldContainer
{
    public $fields;
    public $description;
    public $descriptionIcon;

    public function fieldsFlattened()
    {
        return collect($this->fields)->flatMap->fieldsFlattened();
    }

    public function panels($object)
    {
        return collect($this->fields)->filter(function ($field) {
            return $field instanceof FieldContainer;
        })->flatMap->panels($object);
    }

    public function withObject($object): void {}

    public function withDesc(string $desc, ?string $icon = null) : self
    {
        $this->description = $desc;
        $this->descriptionIcon = $icon;
        return $this;
    }
}
