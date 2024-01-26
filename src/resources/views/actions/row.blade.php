<x-ui::tertiary-button
        class='{{$classes}}'
        href='{{$link}}' :confirm="$confirm ?? null"
>
    <div class="flex items-center space-x-2">
        @if($icon) <x-ui::icon>{{$icon}}</x-ui::icon>@endif
        @if($title)<div class="hidden sm:block">{{ $title }}</div>@endif
    </div>
</x-ui::tertiary-button>
