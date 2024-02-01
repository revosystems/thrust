@extends(config('thrust.indexLayout'))
@section('content')
{{--    <x-thrust::searchSingle />--}}
    <div class="description mb4 thrust-single-resource">
        {!! ( new BadChoice\Thrust\Html\Edit($resource, $resourceName))->show($object, true)  !!}
    </div>
@stop

{{--@section('scripts')--}}
{{--    @parent--}}
{{--    @include('thrust::components.js.searchSingle')--}}
{{--@stop--}}
