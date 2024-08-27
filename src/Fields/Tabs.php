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
            'fields' => $this->editFields($resource),
            'object' => $object,
        ]);
    }

    private function editFields($resource)
    {
        return collect($this->fields)->map(function ($tab) use ($resource) {
            $tab->fields = collect($tab->fields)->filter(fn ($field) => $field->showInEdit && $resource->can($field->policyAction))->all();
            return $tab;
        })->all();
    }

}
