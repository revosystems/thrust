<form action="{{$link}}" method="post">
    @csrf()
    @method('DELETE')
    <x-ui::tertiary-button type="submit" :async="true" x-ref="button" :confirm="$confirm">
        <div class="flex items-center space-x-2">
            @if($icon) <x-ui::icon>{{$icon}}</x-ui::icon>@endif
            @if($title)<div class="hidden sm:block">{{ $title }}</div>@endif
        </div>
    </x-ui::tertiary-button>
</form>
