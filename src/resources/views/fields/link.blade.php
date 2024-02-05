<x-ui::a href="{{$url}}" class="{{$class}}" {{$attributes}} >
            @if(isset($icon) && $icon)
                <x-ui::tertiary-button>
                        <x-ui::icon>{{$icon}}</x-ui::icon>
                </x-ui::tertiary-button>
            @else
                {{$value}}
            @endif
</x-ui::a>