<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\ResourceGate;
use Illuminate\Routing\Controller;
use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\ChildResource;

class ThrustMorphManyController extends Controller
{
    public function index($resourceName, $id, $relationship)
    {
        $resource           = Thrust::make($resourceName);
        $object             = $resource->find($id);
        $morphManyField     = $resource->fieldFor($relationship);
        $childResource      = Thrust::make($morphManyField->resourceName)->parentId($id);
        $childResource->morphed = $object;
        app(ResourceGate::class)->check($resource, 'index');

        $backHasManyURLParams = $resource instanceof ChildResource ? $resource->getParentHasManyUrlParams($object) : null;

        return view('thrust::index', [
            'resourceName'            => $morphManyField->resourceName,
            'searchable'              => count($resource::$search) > 0,
            'resource'                => $childResource,
            'actions'                 => collect($childResource->actions()),
            'parent_id'               => $id,
            'isChild'                 => $resource instanceof ChildResource && $backHasManyURLParams,
            'hasManyBackUrlParams'    => $backHasManyURLParams,
            'description'             => $childResource->getDescription(),
            'morphed'                 => get_class($object),
        ]);
    }
}
