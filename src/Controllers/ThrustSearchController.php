<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Html\Index;
use Illuminate\Routing\Controller;

class ThrustSearchController extends Controller
{
    public function index($resourceName, $searchText)
    {
        request()->merge(['search' => $searchText]);
        $resource = Thrust::make($resourceName);
        if ($resource::$searchResource){        
            $resource = Thrust::make($resource::$searchResource);
        }

        $resource->setSearchText(request('search'));

        return (new Index($resource))->show();
    }

    public function json($resourceName)
    {
        $resource = Thrust::make($resourceName);
        if ($resource::$searchResource){        
            $resource = Thrust::make($resource::$searchResource);
        }

        $resource->setSearchText(request('search'));

        return response()->json($resource->query()->limit(50)->get()->map(function($object) use($resource) {
            return [
                "id" => $object->id,
                "name" => $object->{$resource->nameField}
            ];
        }));
    }
}
