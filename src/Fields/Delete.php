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
            'confirm' => $this->getConfirmMessage(),
            'deletion' => true,
            'message' => $this->displayMessage($object)
        ]);
    }

    public function displayInEdit($object, $inline = false){ }

    public function withMessage(Closure|string $message): self
    {
        $this->message = $message;
        return $this;
    }

    protected function displayMessage($object) {
        return empty($this->getMessage($object)) 
            ? $this->getDefaultMessage($object) 
            : $this->getMessage($object);
    }

    protected function getConfirmMessage(): string
    {
        return __("thrust::messages.deleteResource");
    }

    protected function getMessage(mixed $object): string
    {
        if ($this->message instanceof Closure) {
            return ($this->message)($object);
        }

        return $this->message;
    }

    protected function getDefaultMessage(mixed $object): string
    {
        return __("thrust::messages.deleteResourceDesc", ['resourceName' => $object->name]);
    }

}