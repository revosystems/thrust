<x-ui::secondary-button class='{{$classes}}' href='{{$link}}'>
    <div class="flex items-center space-x-2">
        @if($icon) <x-ui::icon>{{$icon}}</x-ui::icon>@endif
        <div class="hidden sm:block">{{ $title }}</div>
    </div>
</x-ui::secondary-button>
