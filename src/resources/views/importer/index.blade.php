@extends(config('thrust.indexLayout'))
@section('content')
    <div class="thrust-index-header description">
        <span class="thrust-index-title title">
            <a href="{{route('thrust.index', $resourceName) }}">{{ $resource->getTitle() }}</a> / {{  __('thrust::messages.import') }}
        </span>
    </div>

    <div class="ml-4 p-4 bg-white shadow mt-8">
        <form action="{{route('thrust.uploadCsv', $resourceName)}}" method="POST"  enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <p>{{ __('thrust::messages.selectCsvFile') }}</p> 

            <x-ui::forms.file id="csv" name="csv" accept=".csv" required class="w-fit" />
            
            <x-ui::go-button type="submit" :async="true">
                {{ __('thrust::messages.next') }}
            </x-ui::go-button>
        </form>
    </div>
@stop