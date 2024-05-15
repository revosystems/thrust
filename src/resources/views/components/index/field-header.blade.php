@props(['field'])
<div class='{{$field->getSortableHeaderClass()}}'>
    @if ($field->sortableInIndex() && !request('search'))
    <x-ui::sort-header
        :active="request('sort') == $field->sortField"
        direction="{{strtolower(request('sort_order'))}}"
        :sortDescLink="BadChoice\Thrust\ResourceFilters\Sort::link($field->sortField, 'desc')"
        :sortAscLink="BadChoice\Thrust\ResourceFilters\Sort::link($field->sortField, 'asc')"
        :tooltip="$field->getTooltip()"
    >
        {{ $field->getTitle(true) }}
    </x-ui::sort-header>
    @else
        <x-ui::tooltip :enabled="$field->getTooltip()!== null">
            <x-slot name="trigger">{{ $field->getTitle(true) }}</x-slot>
            {{ $field->getTooltip() }}
        </x-ui::tooltip>
    @endif
{{--        {{ $field->getTooltip() }}--}}
</div>