@if ($withLink)
    <x-ui::a href="{{route('thrust.belongsToMany', [$resourceName, $id , $relationship])}}" class="showPopup">
        @if($icon)
            <i class="fa fa-{{$icon}}" style="color:black; font-size:15px"></i>
        @elseif( strlen($value) == 0)
            --
        @else
            {!! $value !!}
        @endif
    </x-ui::a>
@else
    {!! $value !!}
@endif