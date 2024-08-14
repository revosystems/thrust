<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;

class Tabs extends Panel
{
    public function displayInEdit($object, $inline = false)
    {
        $resource = Thrust::make(Thrust::resourceNameFromModel($object));

        $fields = collect($this->fields)->map(function ($tab) use ($resource) {
            $tab->fields = collect($tab->fields)->filter(fn ($field) => $field->showInEdit && $resource->can($field->policyAction))->all();
            return $tab;
        })->all();

        return view('thrust::fields.tabs', [
            'id' => $this->panelId,
            'fields' => $fields,
            'object' => $object,
        ]);
    }

}
