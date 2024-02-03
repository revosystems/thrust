<x-ui::table.table>
    <x-ui::table.header>
    @if (! $belongsToManyField->hideName)
        <x-ui::table.row>
            @if ($sortable)
                <x-ui::table.header-cell></x-ui::table.header-cell>
            @endif
            <x-ui::table.header-cell>
                {{ trans_choice(config('thrust.translationsPrefix') . Illuminate\Support\Str::singular($belongsToManyField->field), 1) }}
            </x-ui::table.header-cell>
        @endif
        @foreach($belongsToManyField->objectFields as $field)
            <x-ui::table.header-cell> {{$field->getTitle()}}</x-ui::table.header-cell>
        @endforeach
        @foreach($belongsToManyField->pivotFields as $field)
            @if(!$field->shouldHide($object, 'edit'))
                <x-ui::table.header-cell> {{$field->getTitle()}}</x-ui::table.header-cell>
            @endif
        @endforeach
        <x-ui::table.header-cell></x-ui::table.header-cell>
        @if ($belongsToManyField->canEdit())
            <x-ui::table.header-cell></x-ui::table.header-cell>
        @endif
        </x-ui::table.row>
    </x-ui::table.header>
    <x-ui::table.body class="@if ($sortable) sortableChild @endif">
    @foreach ($children as $row)
        <x-ui::table.row id="sort_{{$row->pivot->id}}">
            @if ($sortable)
                <x-ui::table.cell class="sort w-10 hidden sm:table-cell"></x-ui::table.cell>
            @endif
            @if (! $belongsToManyField->hideName)
                <x-ui::table.cell>
                    {{ $row->{$relationshipDisplayName} }}
                </x-ui::table.cell>
            @endif
            @foreach($belongsToManyField->objectFields as $field)
                <x-ui::table.cell>{!! $field->displayInIndex($row)  !!}</x-ui::table.cell>
            @endforeach
            @foreach($belongsToManyField->pivotFields as $field)
                @if(!$field->shouldHide($object, 'edit'))
                    <x-ui::table.cell>{!! $field->displayInIndex($row->pivot)  !!}</x-ui::table.cell>
                @endif
            @endforeach
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'delete', $row->pivot))
                <x-ui::table.cell class="w-10"> <a class="delete-resource" data-delete="confirm resource" confirm-message="{{ __('admin.confirmDelete') }}" href="{{route('thrust.belongsToMany.delete', [$resourceName, $object->id, $belongsToManyField->field, $row->pivot->id])}}"></a></x-ui::table.cell>
            @endif
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'edit', $row->pivot) && $belongsToManyField->canEdit())
                <x-ui::table.cell class="w-10"> <a class='edit thrust-edit' id="edit_{{$row->pivot->id}}"></a></x-ui::table.cell>
            @endif
        </x-ui::table.row>
    @endforeach
    </x-ui::table.body>
</x-ui::table.table>
@include('thrust::components.paginator', ["data" => $children, 'popupLinks' => true])
