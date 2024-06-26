@extends(config('thrust.indexLayout'))
@section('content')
    <div class="thrust-index-header description">
        <span class="thrust-index-title title">
            <a href="{{route('thrust.index', $resourceName) }}">{{ $resource->getTitle() }}</a> / {{  __('thrust::messages.import') }}
        </span>
    </div>

    <div class="m-4 bg-white p-4 shadow">

        <div class="mb-4">
        {{ __('thrust::messages.rowsToImport' )}}: <b>{{ count($importer->rows()) }}</b>
        </div>

        <form method="post" action="{{route('thrust.doImport', $resourceName)}}" enctype="multipart/form-data">
        @csrf
       <input type="hidden" name="csv" value="{{$importer->csv}}">
            @include('thrust::importer.fieldMapping', [
             'field' => 'id',
             'title' => 'Id',
             'required' => false,
             'csvFields' => $importer->fields(),
        ])

        @foreach($resource->fieldsFlattened()->filter(fn($field) => $field->importable) as $thrustField)
            @include('thrust::importer.fieldMapping', [
                'field' => $thrustField->databaseField((new $resource::$model)),
                'title' => $thrustField->getTitle() == "" ? $thrustField->field : $thrustField->getTitle(),
                'required' => $thrustField->isRequired(),
                'csvFields' => $importer->fields(),
            ])
           @endforeach
            <div class="mt-4">
                <x-ui::primary-button :async="true" type="submit">
                    {{ __('thrust::messages.import') }}
                </x-ui::primary-button>
            </div>
        </form>
    </div>

@stop