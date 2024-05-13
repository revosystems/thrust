@if ($withLink)
    <x-ui::a href="{{route('thrust.belongsToMany', [$resourceName, $id , $relationship])}}" class="showPopup">
        @if($icon)
            <x-ui::icon>{{$icon}}</x-ui::icon>
        @elseif( strlen($value) == 0)
            --
        @else
            {!! $value !!}
        @endif
    </x-ui::a>
@else
    {!! $value !!}
@endif