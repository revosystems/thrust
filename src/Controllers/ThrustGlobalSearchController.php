<?php

namespace BadChoice\Thrust\Controllers;

use App\Http\Controllers\Controller;
use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Resource;
use Illuminate\Support\Str;

class ThrustGlobalSearchController extends Controller
{
    protected string $search;

    public function index(){

        $this->search = strtolower(request('search'));
        $found = collect(Thrust::resources())->mapWithKeys(function($class){
            $resource = (new $class());
            if (!$resource::$allowsGlobalSearch) { return []; }
            return [$class => $this->matchingResource($resource)];
        })->filter(function($data){
            return count($data['fields']) > 0 ||
                count($data['models']) > 0 ||
                Str::contains(strtolower($data['resource']->getTitle()), $this->search);
        });

        return view('thrust::globalSearch.index', [
            'found' => $found
        ]);
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
                return Str::contains(strtolower($field->getTitle()), $this->search);
            } catch(\Exception $e) {
                dd($e, $field, $resource);
                return false;
            }
        });
    }

    protected function matchingModels($resource) : \Illuminate\Support\Collection  {
        if (count($resource::$search) == 0) { return collect(); }
        return $resource->query()->get();
    }
}
