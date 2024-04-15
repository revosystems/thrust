@include('thrust::components.paginator', ["data" => $rows])
@if (count($rows) > 0)
    <x-ui::table.table>
        <x-ui::table.header>
            <x-ui::table.row>
            <x-ui::table.header-cell class="w-8 pl-4 text-center">
                <x-ui::forms.check onclick="toggleSelectAll(this)" />
            </x-ui::table.header-cell>
            @if ($sortable)
                <x-ui::table.header-cell class="hidden w-8 text-center sm:table-cell" />
            @endif
            @foreach($fields as $field)
                <x-ui::table.header-cell class="{{ $field->getRowCss() }}">
                    <x-thrust::index.field-header :field="$field"/>
                </x-ui::table.header-cell>
            @endforeach
            </x-ui::table.row>
        </x-ui::table.header>

        <x-ui::table.body class="@if($sortable) sortable @endif">
            @foreach ($rows as $row)
                <x-ui::table.row id="sort_{{$row->id}}" >
                    <x-ui::table.cell class="pl-4 w-8 text-center">
                        <x-ui::forms.check class='actionCheckbox' name="selected[{{$row->id}}]" meta:id="{{$row->id}}" />
                    </x-ui::table.cell>
                    @if ($sortable)
                        <x-ui::table.cell class="sort w-8 text-center hidden sm:table-cell text-gray-300 cursor-grab">
                            @icon(grip-lines)
                        </x-ui::table.cell>
                    @endif
                    @foreach($fields as $field)
                        <x-ui::table.cell class="{{$field->getRowCss()}}">
                            @if (! $field->shouldHide($row, 'index') && $field->shouldShow($row, 'index') && $resource->can($field->policyAction, $row))
                                {!! $field->displayInIndex($row) !!}
                            @endif
                        </x-ui::table.cell>
                    @endforeach
                </x-ui::table.row>
            @endforeach
        </x-ui::table.body>
    </x-ui::table.table>
    @include('thrust::components.paginator',["data" => $rows])
@else
    <x-thrust::no-data />
@endif
