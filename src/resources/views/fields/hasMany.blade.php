@if ($withLink)
    @if($link)
        <a href="{{ url($link) }}" class="text-blue-400">
    @else
        <a href="{{ route('thrust.hasMany', [$resourceName, $id , $relationship]) }}" class="text-blue-400">
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