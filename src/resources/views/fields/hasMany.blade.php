@if ($withLink)
    @if($link)
        <a href="{{ url($link) }}">
    @else
        <a href="{{ route('thrust.hasMany', [$resourceName, $id , $relationship]) }}">
    @endif
        @if($icon)
            <x-ui::icon>{{$icon}}</x-ui::icon> {{ $value }}
        @elseif( strlen($value) == 0)
            --
        @else
            {{ $value }}
        @endif
    </a>
@else
    {{ $value }}
@endif