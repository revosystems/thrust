@props(['resource', 'parentId', 'isChild'])
<div class="">
    @if (isset($parentId) )
    @php $parent = $resource->parent($parentId) @endphp
    @if($isChild)
        <x-ui::a href="{{ route('thrust.hasMany', $hasManyBackUrlParams) }}"> {{ \BadChoice\Thrust\Facades\Thrust::make(app(\BadChoice\Thrust\ResourceManager::class)->resourceNameFromModel($parent))->parent($parent)->name }} </x-ui::a>
    @elseif (in_array(\BadChoice\Thrust\Contracts\CustomBackRoute::class,class_implements(get_class($resource))))
        <x-ui::a href="{{ $resource->backRoute() }}"> {{ $resource->backRouteTitle() }} </x-ui::a>
    @else
        <x-ui::a href="{{ route('thrust.index', [app(\BadChoice\Thrust\ResourceManager::class)->resourceNameFromModel($parent) ]) }}"> {{ trans_choice(config('thrust.translationsPrefix') . Illuminate\Support\Str::singular(app(\BadChoice\Thrust\ResourceManager::class)->resourceNameFromModel($parent)), 2) }} </x-ui::a>
    @endif
    <span class="text-sm text-gray-400">@icon(chevron-right)</span>
    <span>{{ $parent->name }}</span>
    <span class="text-sm text-gray-400">@icon(chevron-right)</span>
    @endif
    {{ $resource->getTitle() }}
    <span class="text-gray-400">
        ({{ $resource->rows()->total() }})
    </span>
</div>
