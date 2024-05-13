<?php

namespace BadChoice\Thrust\Fields;

class Email extends Text
{
    protected ?string $icon = "envelope";
    
    public function displayInIndex($object)
    {
        return view('thrust::fields.email', [
            "value" => $this->getValue($object)
        ]);
    }

    protected function getFieldType()
    {
        return 'email';
    }
}
