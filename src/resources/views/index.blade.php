@extends(config('thrust.indexLayout'))
@section('content')
    <div class="flex flex-col space-y-2">
        <div class="flex items-center justify-between">
            <x-thrust::index.title :resource="$resource" :parentId="$parent_id" :isChild="$isChild"/>
            <x-thrust::mainActions :resource="$resource" :resourceName="$resourceName"/>
        </div>

        <div class="">
            {!! $description ?? "" !!}
        </div>

        <div class="flex items-center justify-between">
            @if($searchable) <x-thrust::search /> @endif
            <div class="">
                @include('thrust::components.filters')
                @include('thrust::components.actions')
            </div>
        </div>
    </div>


    <div id="all" @if(request('search')) style="display: none;" @endif>
        {!! (new BadChoice\Thrust\Html\Index($resource))->show() !!}
    </div>
    <div id="results"></div>
@stop

@section('scripts')
    @parent
    @if ($searchable)
        @include('thrust::components.searchScript', ['resourceName' => $resourceName])
    @endif
    @include('thrust::components.js.actions', ['resourceName' => $resourceName])
    @include('thrust::components.js.filters', ['resourceName' => $resourceName])
    @include('thrust::components.js.editInline', ['resourceName' => $resourceName])
@stop
