<?php

namespace BadChoice\Thrust\Fields;

class Tabs extends Panel
{
    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.tabs', [
            'id' => $this->panelId,
            'fields' => $this->fields,
            'object' => $object
        ]);
    }

}
