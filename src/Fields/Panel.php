<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Fields\Traits\Visibility;
use Illuminate\Support\Str;

class Panel extends FieldContainer
{
    use Visibility;

    public $showInEdit = true;
    public $title;
    public $icon;
    public $panelId;
    public $panelClass = 'formPanel';

    public $policyAction = null;

    public $excludeOnMultiple = false;

    public static function make($fields, $title = null)
    {
        $panel         = new static;
        $panel->fields = $fields;
        $panel->title  = $title;
        return $panel;
    }

    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function panelId($id)
    {
        $this->panelId = $id;
        return $this;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.panel', [
            'id' => $this->getId(),
            'object' => $object,
            'icon' => $this->icon,
            'title' => $this->title,
            'fields' => collect($this->fields)->filter->showInEdit,
            'description' => $this->description,
            'descriptionIcon' => $this->descriptionIcon
        ]);
    }

    public function getId()
    {
        return $this->panelId ?? Str::slug($this->title);
    }

    public function shouldShow($object, $state)
    {
        return true;
    }

    public function shouldHide($object, $state)
    {
        return false;
    }

    public function panels($object)
    {
        return parent::panels($object)->push($this);
    }
}
