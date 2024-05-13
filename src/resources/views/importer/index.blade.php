@extends(config('thrust.indexLayout'))
@section('content')
    <div class="thrust-index-header description">
        <span class="thrust-index-title title">
            <a href="{{route('thrust.index', $resourceName) }}">{{ $resource->getTitle() }}</a> / {{  __('thrust::messages.import') }}
        </span>
    </div>

    <div class="ml-4 p-4 bg-white shadow mt-8">
        <form action="{{route('thrust.uploadCsv', $resourceName)}}" method="POST"  enctype="multipart/form-data">
             @csrf
            <div class="flex-row space-y-4">
                <div>{{ __('thrust::messages.selectCsvFile') }}</div>
                <div><input type="file" required name="csv"></div>
                <div>
                    <x-ui::go-button type="submit" :async="true">
                        {{ __('thrust::messages.next') }}
                    </x-ui::go-button>
                </div>
            </div>
        </form>
    </div>
@stop