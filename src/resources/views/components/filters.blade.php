@props(['resource', 'filters'])
@if ($filters && count($filters) > 0)
    <x-ui::dropdown :offset="14" :arrow="true">
        <x-slot name="trigger">
            <x-ui::secondary-button>
                @icon(filter) @icon(caret-down)
            </x-ui::secondary-button>
        </x-slot>
        <?php $filtersApplied = $resource->filtersApplied(); ?>
        <form id="filtersForm">
            <div class="flex flex-col space-y-4">
                @foreach (collect($filters) as $filter)
                    <div class="flex flex-col space-y-1">
                        <div> {!! $filter->getIcon() !!} {!! $filter->getTitle() !!}</div>
                        <div class="text-left">
                            {!! $filter->display($filtersApplied) !!}
                        </div>
                    </div>
                @endforeach
                <x-ui::secondary-button
                        class="w-full"
                        async="true"
                        type="submit">
                    {{ __("thrust::messages.apply") }}
                </x-ui::secondary-button>
            </div>
        </form>
    </x-ui::dropdown>
@endif