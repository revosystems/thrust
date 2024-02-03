<a href="{{$url}}" class="{{$class}}" {{$attributes ?? ''}}>
        <x-ui::tertiary-button>
            @if(isset($icon) && $icon)
                <x-ui::icon>{{$icon}}</x-ui::icon>
            @else
                {{$value}}
            @endif
        </x-ui::tertiary-button>
</a>