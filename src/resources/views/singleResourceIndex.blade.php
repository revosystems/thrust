@extends(config('thrust.indexLayout'))
@section('content')
{{--    <x-thrust::searchSingle />--}}
    <div class="flex justify-center bg-white pt-4 px-4 sm:px-0">
        <div class="w-full max-w-xl">
        {!! ( new BadChoice\Thrust\Html\Edit($resource, $resourceName))->show($object, true)  !!}
        </div>
    </div>
@stop

{{--@section('scripts')--}}
{{--    @parent--}}
{{--    @include('thrust::components.js.searchSingle')--}}
{{--@stop--}}
