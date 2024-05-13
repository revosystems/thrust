@if($id)
<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline">
        @if($withLink)
        <a href="{{route('thrust.image.edit', [$resourceName, $id, $field]) }}" class="showPopup">
        @endif
            @if ($path && $exists)
                <img src='{{ asset($path) }}' class='{{$classes}}' style='{{$style}}'>
            @elseif($path)
                <x-ui::secondary-button> @icon(triangle-exclamation) </x-ui::secondary-button>
            @elseif($gravatar)
                {!! $gravatar !!}
            @else
                <x-ui::secondary-button> @icon(image) </x-ui::secondary-button>
            @endif
        @if($withLink)
        </a>
        @endif
</x-thrust::formField>
@endif
