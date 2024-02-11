@extends(config('thrust.indexLayout'))
@section('content')
{{--    <x-thrust::searchSingle />--}}
    <div class="description mb4 thrust-single-resource">
        <div class="max-w-xl">
        {!! ( new BadChoice\Thrust\Html\Edit($resource, $resourceName))->show($object, true)  !!}
        </div>
    </div>
@stop

{{--@section('scripts')--}}
{{--    @parent--}}
{{--    @include('thrust::components.js.searchSingle')--}}
{{--@stop--}}
