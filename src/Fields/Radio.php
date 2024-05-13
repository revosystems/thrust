<?php

namespace BadChoice\Thrust\Fields;

use Illuminate\Support\Collection;

class Radio extends Field
{
    protected array $options = [];
    protected array $images = [];
    protected array $descriptions = [];
    protected bool $showAside = false;

    public function options(array|Collection $options)
    {
        $this->options = is_array($options)
            ? $options
            : $options->toArray();
        return $this;
    }

    public function images(array $images) : self
    {
        $this->images = $images;
        return $this;
    }

    public function descriptions(array $descriptions) : self
    {
        $this->descriptions = $descriptions;
        return $this;
    }

    public function showAside(bool $showAside = true) : self
    {
        $this->showAside = $showAside;
        return $this;
    }

    public function displayInIndex($object)
    {
        return $this->getOptions()[$this->getValue($object)] ?? '--';
    }

    public function displayInEdit($object, $inline = false)
    {
        return view('thrust::fields.radio', [
            'title'       => $this->getTitle(),
            'inline'      => $inline,
            'field'        => $this->field,
            'value'       => $this->getValue($object),
            'options'     => $this->options,
            'images'      => $this->images,
            'descriptions' => $this->descriptions,
            'description' => $this->getDescription(),
            'showAside'   => $this->showAside,
            'learnMoreUrl'=> $this->learnMoreUrl,
        ])->render();
    }
}
