<div class="flex flex-col gap-4">
    @if ($fileField->displayPath($object) && $fileField->exists($object))
        <div class="flex gap-2 items-center p-2 rounded border border-gray-200 w-fit">
            @icon(file)
            <span>{{ basename($fileField->displayPath($object)) }}</span>
        </div>
    @endif

    <form action="{{ route('thrust.file.store', [$resourceName, $object->id, $fileField->field]) }}" method="POST" enctype="multipart/form-data" id="submitForm">
        {{ csrf_field() }}
        <input type="file" name="file" id="file" class="block border border-gray-200 shadow-sm rounded text-xs focus:z-10 outline-none focus:outline-none ring-0 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none
            file:bg-gray-100 file:border-0 file:me-4 file:py-2 file:px-4">
    </form>
    <form action="{{ route('thrust.file.delete', [$resourceName, $object->id, $fileField->field]) }}" method="POST" class="hidden" id="deleteForm">
        {{ csrf_field() }}
        {{ method_field('delete')  }}
    </form>

    <div class="flex gap-2 items-center">
        <x-ui::primary-button type=submit async form="submitForm">{{ __("thrust::messages.save") }}</x-ui::primarybutton>
        @if ($fileField->displayPath($object) && $fileField->exists($object))
            <x-ui::secondary-button type=submit async form="deleteForm">@icon(trash) {{ __("thrust::messages.delete") }}</x-ui::secondary-button>
        @endif
    </div>
</div>
