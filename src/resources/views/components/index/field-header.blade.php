@props(['field'])
<div class='max-w-sm {{$field->getSortableHeaderClass()}}'>
    @if ($field->sortableInIndex() && !request('search'))
    <x-ui::sort-header
            :active="request('sort') == $field->field"
            direction="{{strtolower(request('sort_order'))}}"
            :sortDescLink="BadChoice\Thrust\ResourceFilters\Sort::link($field->field, 'desc')"
            :sortAscLink="BadChoice\Thrust\ResourceFilters\Sort::link($field->field, 'asc')"
    >
        {{ $field->getTitle(true) }}
    </x-ui::sort-header>
    @else
        {{ $field->getTitle(true) }}
    @endif
{{--        {{ $field->getTooltip() }}--}}
</div>