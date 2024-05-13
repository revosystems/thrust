@if($withLinks)
    <a class="thrust-toggle" href="{{route('thrust.toggle', [$resourceName, $id, $field])}}">
@endif
@if ($value)
    <i class="fa @if($asSwitch) fa-2x fa-toggle-on @else fa-check @endif text-green-400"></i>
@else
    <i class="fa @if($asSwitch) fa-2x fa-toggle-off @else fa-times red @endif text-neutral-200"></i>
@endif
@if($withLinks)
    </a>
@endif
