<?php

namespace BadChoice\Thrust\Controllers;

use App\Http\Controllers\Controller;
use BadChoice\Thrust\GlobalSearch\GlobalSearch;

class ThrustGlobalSearchController extends Controller
{
    protected string $search;

    public function index(){

        $found = app()->make(GlobalSearch::class)->search(request('search'));

        return view('thrust::globalSearch.index', [
            'found' => $found
        ]);
    }



}
