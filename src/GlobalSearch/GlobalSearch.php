<?php

namespace BadChoice\Thrust\GlobalSearch;

use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Resource;
use Illuminate\Support\Str;

class GlobalSearch
{
    protected string $search;

    public function search($text){
        $this->search = withoutDiacritic(mb_strtolower($text));
        return collect(Thrust::resources())->map(function($class){
            $resource = (new $class());
            if (!$resource::$allowsGlobalSearch) { return null; }
            return $this->matchingResource($resource);
        })->filter()->filter(function($data){
            return count($data['fields']) > 0 ||
                count($data['models']) > 0 ||
                Str::contains(withoutDiacritic(mb_strtolower($data['resource']->getTitle())), $this->search);
        });
    }

    protected function matchingResource(Resource $resource) : array {
        return [
            'resource' => $resource,
            'fields' => $this->matchingFields($resource),
            'models' => $this->matchingModels($resource)
        ];
    }

    protected function matchingFields(Resource $resource) : \Illuminate\Support\Collection
    {
        return collect($resource->fieldsFlattened())->filter(function($field) use($resource){
            try {
//                dd($this->search, $field->getTitle());
                return Str::contains(withoutDiacritic(mb_strtolower($field->getTitle())), $this->search);
            } catch(\Exception $e) {
                dd($e, $field, $resource);
                return false;
            }
        });
    }

    protected function matchingModels($resource) : \Illuminate\Support\Collection  {
        if (count($resource::$search) == 0) { return collect(); }
        return $resource->query()->get()->filter(function($model) use($resource) {
            return $resource->canEdit($model);
        });
    }
}