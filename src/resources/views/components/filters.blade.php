@props(['resource', 'filters'])
@if ($filters && count($filters) > 0)
    <x-ui::dropdown :arrow="true" :offset="8">
        <x-slot name="trigger">
            <x-ui::secondary-button>
                @icon(filter) @icon(caret-down)
            </x-ui::secondary-button>
        </x-slot>
        <?php $filtersApplied = $resource->filtersApplied(); ?>
        <div class="flex flex-col space-y-4">
            <form id="filtersForm">
            @foreach (collect($filters) as $filter)
                <div>
                    <div> {!! $filter->getIcon() !!} {!! $filter->getTitle() !!}</div>
                    <div class="text-left">
                        {!! $filter->display($filtersApplied) !!}
                    </div>
                </div>
            @endforeach
            <x-ui::secondary-button async="true" type="submit">{{ __("thrust::messages.apply") }}</x-ui::secondary-button>
            </form>
        </div>
    </x-ui::dropdown>
@endif