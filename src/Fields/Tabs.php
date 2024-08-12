<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;

class Tabs extends Panel
{
    public function displayInEdit($object, $inline = false)
    {
        $resource = Thrust::make(Thrust::resourceNameFromModel($object));

        return view('thrust::fields.tabs', [
            'id' => $this->panelId,
            'fields' => $this->fields,
            'object' => $object,
            'resource' => $resource,
        ]);
    }

}
