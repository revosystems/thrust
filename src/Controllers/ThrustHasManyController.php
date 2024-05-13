<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\ResourceGate;
use Illuminate\Routing\Controller;
use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\ChildResource;

class ThrustHasManyController extends Controller
{
    public function index($resourceName, $id, $relationship)
    {
        $resource           = Thrust::make($resourceName);
        $object             = $resource->find($id);
        $hasManyField       = $resource->fieldFor($relationship);
        $childResource      = Thrust::make($hasManyField->resourceName)->parentId($id);
        app(ResourceGate::class)->check($resource, 'index');

        return view('thrust::index', [
            'resourceName'            => $hasManyField->resourceName,
            'searchable'              => count($resource::$search) > 0,
            'resource'                => $childResource,
            'actions'                 => collect($childResource->actions()),
            'parent_id'               => $id,
            'description'             => $childResource->getDescription(),
//            "object"                  => $object,
//            "title"                   => $object->{$resource->nameField},
//            "children"                => $object->{$relationship},
//            "belongsToManyField"      => $hasManyField,
        ]);
    }
}
