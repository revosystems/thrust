<?php

namespace BadChoice\Thrust\Fields;

use BadChoice\Thrust\Facades\Thrust;
use Closure;

class Delete extends Field {

    public bool $showInEdit          = false;
    public bool $withoutIndexHeader  = true;
    public string $rowClass          = '!py-0 !px-0 w-8 sm:w-10 text-center';
    public $policyAction             = 'delete';
    public bool $importable          = false;
    public Closure|string $message   = '';

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
            'deletion' => true,
            'message' => $this->getMessage($object)
        ]);
    }

    public function displayInEdit($object, $inline = false){ }

    public function withMessage(Closure|string $message): self
    {
        $this->message = $message;
        return $this;
    }

    protected function getMessage(mixed $object): string
    {
        if ($this->message instanceof Closure) {
            return ($this->message)($object);
        }

        return $this->message;
    }

}