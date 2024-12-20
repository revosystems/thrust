<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\Facades\Thrust;
use BadChoice\Thrust\Html\Edit;
use BadChoice\Thrust\ResourceGate;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ThrustController extends Controller
{
    use AuthorizesRequests;

    public function index($resourceName)
    {
        $resource = Thrust::make($resourceName);
        app(ResourceGate::class)->check($resource, 'index');

        if ($resource::$singleResource) {
            return $this->singleResourceIndex($resourceName, $resource);
        }

        return view('thrust::index', [
            'resourceName'    => $resourceName,
            'resource'        => $resource,
            'actions'         => collect($resource->actions()),
            'searchable'      => count($resource::$search) > 0,
            'searchAutofocus' => $resource::$searchAutofocus,
            'description'     => $resource->getDescription(),
            'header'          => $resource->indexHeader(),
        ]);
    }

    public function create($resourceName)
    {
        $resource = Thrust::make($resourceName);
        app(ResourceGate::class)->check($resource, 'create');
        $object = $resource->makeNew();
        return (new Edit($resource))->show(id: $object, inline: request()->has('inline'));
    }

    public function createMultiple($resourceName)
    {
        $resource = Thrust::make($resourceName);
        app(ResourceGate::class)->check($resource, 'create');
        $object = $resource->makeNew();
        return (new Edit($resource))->show($object, false, true);
    }

    public function edit($resourceName, $id)
    {
        $resource = Thrust::make($resourceName);
        $object   = $resource->find($id);
        app(ResourceGate::class)->check($resource, 'update', $object);
        return (new Edit($resource))->show($object);
    }

    public function editInline($resourceName, $id)
    {
        $resource = Thrust::make($resourceName);
        return (new Edit($resource))->showInline($id);
    }

    public function store($resourceName)
    {
        $resource = Thrust::make($resourceName);
        $resource->validate(request(), null);

        try {
            $result = $resource->create(request()->all());
        } catch (Exception $e) {
            $resource->onStoreFailed();

            return request()->ajax()
                ? response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY)
                : back()->withErrors(['message' => $e->getMessage()]);
        }

        return request()->ajax()
            ? response()->json($result)
            : $this->backWithMessage('created');
    }

    public function storeMultiple($resourceName)
    {
        $resource = Thrust::make($resourceName);
        request()->validate($resource->getValidationRules(null, true));
        $amount   = request()->input('amount'); // amount to create
        $request  = request()->except('amount');

        DB::beginTransaction();
        for ($i = 0; $i < $amount; ++$i) {
            $request = array_merge($request, $resource->generateMultipleFields());

            try {
                $resource->create($request);
            } catch (Exception $e) {
                DB::rollBack();
                return back()->withErrors(['message' => $e->getMessage()]);
            }
        }

        DB::commit();

        return $this->backWithMessage('created');
    }

    public function update($resourceName, $id)
    {
        $resource = Thrust::make($resourceName);
        if (! request()->has('inline')) {
            $resource->validate(request(), $id);
        }

        try {
            $resource->update($id, request()->except('inline'));
        } catch (Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }

        return $this->backWithMessage('updated');
    }

    public function delete($resourceName, $id)
    {
        try {
            Thrust::make($resourceName)->delete($id);
        } catch (Exception $e) {
            return back()->withErrors(['delete' => $e->getMessage()]);
        }

        return $this->backWithMessage('deleted');
    }

    private function singleResourceIndex($resourceName, $resource)
    {
        return view('thrust::singleResourceIndex', [
            'resourceName'  => $resourceName,
            'resource'      => $resource,
            'object'        => $resource->first()
        ]);
    }

    private function backWithMessage(string $message)
    {
        if (session()->has('thrust-redirect')) {
            return redirect(session('thrust-redirect'));
        }
        return back()->withMessage(__("thrust::messages.{$message}"));
    }
}
