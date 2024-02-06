<div class="thrust-main-actions flex items-center">
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
            {!! $action->display($resourceName, $parent_id ?? null) !!}
        </div>
    @endforeach
</div>