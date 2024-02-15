
<div class="mb-8">
    <x-ui::h2>{{ $fileField->getTitle() }}</x-ui::h2>
</div>

<div class="mb-4">
    @if ($fileField->displayPath($object))
        <div class="relative">
        <img class='' src="{{ url($fileField->displayPath($object)) }}" style="">

            <div class="absolute top-0 right-0">
                <form action="{{ route('thrust.image.delete', [$resourceName, $object->id, $fileField->field]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('delete')  }}
                    <x-ui::secondary-button type="submit" :async="true">@icon(trash) {{ __("thrust::messages.delete") }}</x-ui::secondary-button>
                </form>
            </div>
        </div>
    @endif
</div>

<div class="">
    <div class="inline max-h-52">
        <form action="{{ route('thrust.image.store', [$resourceName, $object->id, $fileField->field]) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="image" accept="image/png, image/gif, image/jpeg">
            <div class="my-4">
                <x-ui::primary-button :async="true" type="submit">{{ __("thrust::messages.save") }}</x-ui::primary-button>
            </div>
        </form>
    </div>
</div>
