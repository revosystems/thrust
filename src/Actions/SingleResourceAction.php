<?php

namespace BadChoice\Thrust\Actions;

use BadChoice\Thrust\Resource;
use BadChoice\Thrust\ResourceGate;

abstract class SingleResourceAction
{
    public $title;
    public $icon;
    public Resource $resource;
    public $shouldReload = false;
    public $responseAsPopup = true;

    public static function make($title)
    {
        $action        = new static;
        $action->title = $title;
        $action->icon  = 'plus';
        return $action;
    }

    abstract public function handle();

    public function getClassForJs()
    {
        return str_replace('\\', '\\\\', get_class($this));
    }
    

}
