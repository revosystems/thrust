<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;

class Edit extends Field {

    public bool $showInEdit          = false;
    public bool $withoutIndexHeader  = true;
    public string $rowClass          = '!py-0 !px-0 w-8 sm:w-10 text-center';
    public $policyAction             = 'update';
    public bool $importable          = false;

    public function displayInIndex($object)
    {
        return view('thrust::actions.row',[
            'classes' => 'showPopup',
            'link' => route('thrust.edit', [Thrust::resourceNameFromModel($object), $object->id]),
            'title' => null,
            'icon' => 'pencil'
        ]);
    }

    public function displayInEdit($object, $inline = false){ }

}