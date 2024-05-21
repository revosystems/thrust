<?php

namespace BadChoice\Thrust\Fields\Traits;


use BadChoice\Thrust\Fields\TextLanguage;

trait TranslatableResource
{
    public function create($data){
        $translatableFields = collect($this->fieldsFlattened())->filter(fn($field) => $field instanceof TextLanguage);
        $translations = $translatableFields->mapWithKeys(function($field) use(&$data) {
            $toReturn = ['translation_'.$field->field => $data['translation_'.$field->field]];
            unset($data['translation_'.$field->field]);
            return $toReturn;
        });
        $object = parent::create($data);
        $translatableFields->each(fn($translatableField) => $translatableField->update($object, $translations));
        return $object;
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