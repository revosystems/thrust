<div class="flex flex-col gap-4">
    @if ($fileField->getTitle())
        <x-ui::h2>{{ $fileField->getTitle() }}</x-ui::h2>
    @endif

    @if ($fileField->displayPath($object))
        <img class="size-24 rounded" src="{{ url($fileField->displayPath($object)) }}">
    @endif

    <form action="{{ route('thrust.image.delete', [$resourceName, $object->id, $fileField->field]) }}" method="POST" class="hidden" id="deleteForm">
        {{ csrf_field() }}
        {{ method_field('delete')  }}
    </form>
    
    <form action="{{ route('thrust.image.store', [$resourceName, $object->id, $fileField->field]) }}" method="POST" enctype="multipart/form-data" id="submitForm">
        {{ csrf_field() }}
        <x-ui::forms.file id="image" name="image" accept="image/png, image/gif, image/jpeg" />
    </form>
    
    <div class="flex gap-2 items-center">
        <x-ui::primary-button type=submit async form="submitForm">{{ __("thrust::messages.save") }}</x-ui::primarybutton>
        @if ($fileField->displayPath($object) && $fileField->exists($object))
            <x-ui::secondary-button type=submit async form="deleteForm">@icon(trash) {{ __("thrust::messages.delete") }}</x-ui::secondary-button>
        @endif
    </div>
</div>