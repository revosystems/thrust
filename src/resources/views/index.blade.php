@extends(config('thrust.indexLayout'))
@section('content')
    <div class="flex flex-col space-y-2 px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                @component(config('thrust.sidebar-collapsed-button'))@endcomponent
                <x-thrust::index.title :resource="$resource" :parentId="$parent_id ?? null" :isChild="$isChild ?? false"/>
            </div>
            <x-thrust::main-actions :resource="$resource" :resourceName="$resourceName" :parentId="$parent_id ?? null"/>
        </div>

        <div class="">
            {!! $description ?? "" !!}
        </div>

        <div class="flex items-center justify-between space-x-4">
            @if($searchable) <x-thrust::search /> @endif
            <div class="flex items-center space-x-2">
                <x-thrust::filters :resource="$resource" :filters="$resource->filters()" />
                <x-thrust::actions :actions="$actions" :resourceName="$resourceName"/>
            </div>
        </div>
    </div>

    <div id="all" @class(['hidden' => request('search')])>
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
