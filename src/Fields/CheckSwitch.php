<?php

namespace BadChoice\Thrust\Fields;

class CheckSwitch extends Check
{
    protected bool $asSwitch = true;
    protected bool $inverted = false;

    public function displayInEdit($object, $inline = false)
    {
        return view($inline ? 'thrust::fields.check' : 'thrust::fields.checkSwitch', [
            'title'       => $this->getTitle(),
            'field'       => $this->field,
            'value'       => $this->getValue($object),
            'inline'      => $inline,
            'inverted'    => $this->inverted,
            'description' => $this->getDescription(),
        ])->render();
    }

    public function inverted(bool $inverted = true) : self
    {
        $this->inverted = $inverted;
        return $this;
    }
}
