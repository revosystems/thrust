<?php

namespace BadChoice\Thrust\Fields;

class TextLanguage extends Text
{
    protected $displayInIndexCallback = null;

    protected $relationship = 'translations';
    protected $languages;

    public bool $showInIndex = false;
    public bool $showInEdit  = true;
    public bool $isTextArea  = false;
    public $textAreaRows = 5;
    protected ?string $icon = "language";

    public function languages($languages){
        $this->languages = $languages;
        if ($this->languages == null || count($this->languages) == 0){
            $this->hideInIndex()->hideInEdit();
        }
        return $this;
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.inputLanguage', [
            'inline'          => $inline,
            'languages'       => $this->languages,
            'title'           => $this->getTitle(),
            'type'            => $this->getFieldType(),
            'field'            => 'translation_'.$this->field,
            'value'           => $this->getValue($object),
            'validationRules' => $this->getHtmlValidation($object, $this->getFieldType()),
            'attributes'      => $this->getComponentBagAttributes($object),
            'description'     => $this->getDescription(),
            'isTextArea'      => $this->isTextArea,
            'textAreaRows'    => $this->textAreaRows,
            'icon'            => $this->icon,
            'learnMoreUrl'    => $this->learnMoreUrl,
            'showAside'       => $this->showAside ?? $this->shouldShowAside(),
        ])->render();
    }

    public function isTextArea($rows = null)
    {
        $this->isTextArea = true;
        $this->textAreaRows = $rows == null ? $this->textAreaRows : $rows;
        return $this;
    }

    public function withRelationship(string $relationship) : self {
        $this->relationship = $relationship;
        return $this;
    }
    

    public function getValue($object)
    {
        return $object->{$this->relationship}($this->field)->get()->filter()->mapWithKeys(function ($translation) {
            return [$translation->language => $translation->text];
        });
    }


    public function update($object, &$newData)
    {
        collect($newData['translation_'.$this->field])->each(function($translation, $language) use($object) {
            $compoundKey = [
                'language' => $language,
                'field' => $this->field,
            ];
            if (!$translation) {
                return $object->{$this->relationship}($this->field)->where($compoundKey)->first()?->delete();
            }
            $object->{$this->relationship}($this->field)->updateOrCreate($compoundKey,[
                'text' => $translation
            ]);
        });

        unset($newData['translation_'.$this->field]);
    }

}
