@props(['resource', 'resourceName', 'parentId'])
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
        <div>
            {!! $action->display($resourceName, $parentId) !!}
        </div>
    @endforeach
</div>