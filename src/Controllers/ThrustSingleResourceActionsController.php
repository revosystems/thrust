<?php

namespace BadChoice\Thrust\Controllers;

use BadChoice\Thrust\Facades\Thrust;
use Illuminate\Routing\Controller;
use Illuminate\View\ComponentAttributeBag;

class ThrustSingleResourceActionsController extends Controller
{

    public function perform($resourceName)
    {
        $action = $this->findActionForResource($resourceName, request('action'));
        try {
            $response = $action->handle();
        } catch (\Exception $e) {
            return request()->ajax() ?
                response()->json(['ok' => false, 'message' => $e->getMessage(), 'shouldReload' => false, 'responseAsPopup' => false]) :
                back()->withErrors(['msg' => $e->getMessage()]);
        }

        if (request()->ajax()) {
            return response()->json(['ok' => true, 'message' => $response ?? 'done', 'shouldReload' => $action->shouldReload, 'responseAsPopup' => $action->responseAsPopup]);
        }

        return back()->withMessage($response);
    }

    
    private function findActionForResource($resourceName, $actionClass)
    {
        $resource   = Thrust::make($resourceName);
        $action     =  collect($resource->singleResourceActions())->first(function ($action) use ($actionClass) {
            return get_class($action) === $actionClass;
        });

        $action->resource = request('search') && $resource::$searchResource
            ? Thrust::make($resource::$searchResource)
            : $resource;
            
        return $action;
    }
}
