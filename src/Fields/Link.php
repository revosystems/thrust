<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\View\ComponentAttributeBag;

class Link extends Field
{
    public bool $showInEdit = false;
    protected $link    = '';
    protected $route;
    protected $classes      = '';
    protected $icon         = '';
    protected $displayCount = false;
    protected $displayCallback;
    protected $attributes = [];
    public bool $importable = false;
    protected $asButton = false;

    public function link($link)
    {
        $this->link = $link;
        return $this;
    }

    public function route($route)
    {
        //TODO: Make it work with parameters
        $this->route = $route;
        return $this;
    }

    public function classes($classes)
    {
        $this->classes = $classes;
        return $this;
    }

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function displayCallback($displayCallback)
    {
        $this->displayCallback = $displayCallback;
        return $this;
    }

    public function displayInIndex($object)
    {
        if ($this->displayCallback) {
            $value = call_user_func($this->displayCallback, $object);
            return view('thrust::fields.link',[
                'class'      => $this->classes,
                'url'        => $this->getUrl($object),
                'value'      => $value,
                'attributes' => new ComponentAttributeBag()
            ]);
        }
        return view('thrust::fields.link', [
            'class'        => $this->classes,
            'icon'         => $this->icon,
            'value'        => $this->getTitle(),
            'displayCount' => $this->displayCount,
            'url'          => $this->getUrl($object),
            'attributes'   => new ComponentAttributeBag($this->attributes),
        ])->render();
    }

    public function icon($icon)
    {
        $this->icon     = $icon;
        $this->rowClass = $this->rowClass . ' action';
        return $this;
    }

    public function getRowCss(): string
    {
        if($icon = $this->icon) {
            return parent::getRowCss() . " w-10 ";
        }
        return parent::getRowCss();
    }

    public function getUrl($object)
    {
        if ($this->route) {
            return route($this->route, [$object]);
        }
        return str_replace('{field}', $this->getValue($object), $this->link);
    }

    public function asButton(bool $bool): self
    {
        $this->asButton = $bool;

        return $this;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.edit.link', [
            'asButton'   => $this->asButton,
            'class'      => $this->classes,
            'url'        => $this->getUrl($object),
            'text'       => $this->displayCallback ? call_user_func($this->displayCallback, $object) : $this->getTitle(),
            'attributes' => new ComponentAttributeBag($this->attributes),
        ])->render();
    }
}
