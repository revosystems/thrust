<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;

class Delete extends Field {

    public bool $showInEdit          = false;
    public bool $withoutIndexHeader  = true;
    public string $rowClass          = 'w-10 text-center';
    public $policyAction             = 'delete';
    public bool $importable          = false;

    public function getRowCss(): string
    {
        return '!py-0 !px-0';
    }
    
    public function displayInIndex($object)
    {
        return $this->renderDeleteWithConfirm($object);
    }

    protected function renderDeleteWithConfirm($object) {
        return view('thrust::actions.deleteRow',[
            'link' => route('thrust.delete', [Thrust::resourceNameFromModel($object), $object->id]),
            'title' => null,
            'icon' => 'trash',
            'confirm' => htmlentities($this->getDeleteConfirmationMessage(), ENT_QUOTES),
            'deletion' => true
        ]);

        //$link = route('thrust.delete', [Thrust::resourceNameFromModel($object), $object->id]);
        //$escapedConfirmMessage = htmlentities($this->getDeleteConfirmationMessage(), ENT_QUOTES);
        //return "<a class='delete-resource thrust-delete'".
        //    ( $this->deleteConfirmationMessage ? "data-delete='resource confirm' confirm-message='{$escapedConfirmMessage}'" : "data-delete='resource'") .
        //    " href='{$link}'>Delete</a>";
    }

    public function displayInEdit($object, $inline = false){ }

}