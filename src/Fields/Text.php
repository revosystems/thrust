<?php

namespace BadChoice\Thrust\Fields;

class Text extends Field{

    public function displayInIndex($object){
        return $this->getValue($object);
    }

    public function displayInEdit($object){
        return view('thrust::fields.input',[
            'type' => $this->getFieldType(),
            'field' => $this->field,
            'value' => $this->getValue($object),
            'attributes' => $this->getFieldAttributes()
        ]);
    }

    protected function getFieldType(){
        return 'text';
    }

    protected function getFieldAttributes(){
        return '';
    }

    protected function getValue($object)
    {
        return strip_tags($object->{$this->field});
    }

}
