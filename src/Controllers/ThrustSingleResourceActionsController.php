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
            return $this->handleResponse($action, $action->handle());
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(\Exception $e) {
        return request()->ajax()
            ? response()->json([
                'ok' => false, 
                'message' => $e->getMessage(), 
                'shouldReload' => false, 
                'responseAsPopup' => false
            ])
            : back()->withErrors(['msg' => $e->getMessage()]);
    }

    private function handleResponse($action, $response){
        if (request()->ajax()) {
            return response()->json([
                'ok' => true, 
                'message' => $response ?? 'done', 
                'shouldReload' => $action->shouldReload, 
                'responseAsPopup' => $action->responseAsPopup
            ]);
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

    private function searchingInResource(): bool
    {
        return (bool) request('search', false);
    }
}