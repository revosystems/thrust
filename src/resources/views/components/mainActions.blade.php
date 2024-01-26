@props(['resource', 'resourceName'])
<div class="flex items-center space-x-2">
    <?php
        $mainActions = collect($resource->mainActions());
        if ($resource->sortableIsActive()) {
            $mainActions->prepend(BadChoice\Thrust\Actions\SaveOrder::make('saveOrder'));
        }
        if (request('sort')) {
            $mainActions->prepend(BadChoice\Thrust\Actions\ClearSorting::make('clearSorting'));
        }
    ?>
    @foreach($mainActions as $action)
        {!! $action->display($resourceName, $parent_id ?? null) !!}
    @endforeach
</div>