<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Fields\BelongsToMany;
use BadChoice\Thrust\ResourceGate;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use BadChoice\Thrust\Html\Edit;

class ThrustBelongsToManyController extends Controller
{
    public function index($resourceName, $id, $relationship)
    {
        $resource           = Thrust::make($resourceName);
        $object             = $resource->find($id);
        $belongsToManyField = $resource->fieldFor($relationship);
        $explodedPivotClass = explode('\\', $object->$relationship()->getPivotClass());
        app(ResourceGate::class)->check($resource, 'index');

        return view('thrust::belongsToManyIndex', [
            'resource'                => $resource,
            'resourceName'            => $resourceName,
            'pivotResourceName'       => end($explodedPivotClass),
            'object'                  => $object,
            'title'                   => $object->{$resource->nameField},
            'children'                => $this->belongsToManyFields($belongsToManyField, $relationship, $object)->paginate(100),
            'belongsToManyField'      => $belongsToManyField,
            'relationshipDisplayName' => $belongsToManyField->relationDisplayField,
            'searchable'              => $belongsToManyField->searchable,
            'ajaxSearch'              => $belongsToManyField->ajaxSearch,
            'allowDuplicates'         => $belongsToManyField->allowDuplicates ? '1' : '0',
            'sortable'                => $belongsToManyField->sortable,
        ]);
    }

    public function store($resourceName, $id, $relationship)
    {
        $resource           = Thrust::make($resourceName);
        $object             = $resource->find($id);
        $belongsToManyField = $resource->fieldFor($relationship);
        if (! $belongsToManyField->allowDuplicates && $object->{$relationship}->contains(request('id'))) {
            return back()->withMessage('already exists and duplicates not allowed');
        }
        $object->{$relationship}()->attach(request('id'), $belongsToManyField->mapRequest(request()->except(['id', '_token'])));
        return back()->withMessage('added');
    }

    public function delete($resourceName, $id, $relationship, $pivotId)
    {
        $resource       = Thrust::make($resourceName);
        $object         = $resource->find($id);
        $relationObject = $object->{$relationship}()->wherePivot('id', $pivotId)->first();
        $relationObject->pivot->delete();
        return back()->withMessage('deleted');
    }

    public function search($resourceName, $id, $relationship, $searchText)
    {
        request()->merge(['search' => $searchText]);
        $resource            = Thrust::make($resourceName);
        $object              = $resource->find($id);
        $belongsToManyField  = $resource->fieldFor($relationship);
        $children            = $belongsToManyField->search($object, $searchText)->get();
        $explodedPivotClass  = explode('\\', $object->$relationship()->getPivotClass());
        return view('thrust::belongsToManyTable', [
            'resourceName'            => $resourceName,
            'object'                  => $object,
            'belongsToManyField'      => $belongsToManyField,
            'relationshipDisplayName' => $belongsToManyField->relationDisplayField,
            'children'                => $children,
            'sortable'                => false,
            'pivotResourceName'       => end($explodedPivotClass),
        ]);
    }

    public function updateOrder($resourceName, $id, $relationship)
    {
        $resource  = Thrust::make($resourceName);
        $idsSorted = request('sort');
        $objects   = $resource->find($id)->{$relationship};
//        dd($objects->toArray());
        $idsSorted = array_flip($idsSorted);
        $objects->each(function ($object) use ($idsSorted) {
            $object->pivot->update(['order' => $idsSorted[$object->pivot->id]]);
        });
        return response()->json('OK', 200);
    }

    public function editInLine($resourceName, $id, $relationship, $pivotId)
    {
        $resource           = Thrust::make($resourceName);
        $object             = $resource->find($id);
        $belongsToManyField = $resource->fieldFor($relationship);
        $explodedPivotClass = explode('\\', $object->$relationship()->getPivotClass());
        $pivotResourceName  = end($explodedPivotClass);
        
        return (new Edit(Thrust::make($pivotResourceName)))->showBelongsToManyInline($pivotId, $belongsToManyField);
    }

    protected function belongsToManyFields(BelongsToMany $belongsToManyField, string $relationship, Model $object) : BelongsToManyBuilder
    {
        $query = $object->{$relationship}()->with($belongsToManyField->with);
        return $belongsToManyField->sortable
            ? $query->orderBy('pivot_' . $belongsToManyField->sortField)
            : $query;
    }
}
