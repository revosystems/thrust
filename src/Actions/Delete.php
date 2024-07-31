<?php

namespace BadChoice\Thrust\Actions;

use BadChoice\Thrust\ResourceGate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class Delete extends Action
{
    public $needsConfirmation = true;
    public $icon              = 'trash';
    public $main              = false;
    public array $errors      = [];

    public function __construct()
    {
        $this->title = __('thrust::messages.delete');
    }

    public function handle(Collection $objects)
    {
        $gate = app(ResourceGate::class);

        $objects->each(function ($object) use($gate) {
            if ($gate->can($this->resource, 'delete', $object)) {
                $this->resource->delete($object);
                return;
            }

            if (Gate::getPolicyFor($this->resource) === null) {
                return;
            }

            $gateResponse = Gate::inspect('delete', $object);
            if ($gateResponse->message()) {
                $this->errors[] = $gateResponse->message();
            }
        });

        if (!empty($this->errors)) {
            return redirect()->back()->withErrors(['message' => $this->errors]);
        }
    }

}
