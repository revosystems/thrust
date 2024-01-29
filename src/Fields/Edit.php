<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;

class Edit extends Field {

    public $showInEdit          = false;
    public $withoutIndexHeader  = true;
    public $rowClass            = 'w-10 text-center';
    public $policyAction        = 'update';
    public $importable          = false;

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