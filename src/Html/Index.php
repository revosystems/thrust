<?php

namespace BadChoice\Thrust\Html;

use BadChoice\Thrust\Resource;

class Index
{
    protected $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function getIndexFields()
    {
        return $this->resource->fieldsFlattened()->filter(function($field){
            return $field->showInIndex || request('search') && $field->showInSearch;
        });
    }

    public function show()
    {
        return view('thrust::indexTable', [
            'sortable'  => $this->resource->sortableIsActive(),
            'resource'  => $this->resource,
            'fields'    => $this->getIndexFields(),
            'rows'      => $this->resource->rows()
        ])->render();
    }
}
