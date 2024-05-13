<?php

namespace BadChoice\Thrust\Fields\Traits;


use BadChoice\Thrust\Fields\TextLanguage;

trait TranslatableResource
{
    public function create($data){
        $fields = collect($this->fieldsFlattened())->filter(function($field){
            return $field instanceof TextLanguage;
        });
        Translatable::create($data, $fields, function($data){
            return parent::create($data);
        });
    }

    public function update($id, $newData){
        collect($this->fieldsFlattened())->filter(function($field){
            return $field instanceof TextLanguage;
        })->each(function($translatableField) use($id, &$newData){
            $translatableField->update($this->find($id), $newData);
        });
        return parent::update($id, $newData);
    }
}