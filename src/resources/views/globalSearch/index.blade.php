<div class="flex flex-col divide-y mt-4 gap-2">
    @foreach($found as $data)
        <div class="py-2">
            <div class="font-semibold text-lg mb-2">
                @if($data['resource'] instanceof \BadChoice\Thrust\ChildResource)
                    {{ $data['resource']->getTitle() }}
                @else
                    <a href="{{route('thrust.index', $data['resource']->name())}}">
                        <div class="flex items-center justify-between">
                            <div>{{ $data['resource']->getTitle() }}</div>
                            <div class="text-sm text-gray-400">@icon(arrow-right)</div>
                        </div>
                    </a>
                @endif
            </div>
            @foreach($data['fields'] as $field)
                <div class="text-gray-400 py-1">
                    @icon(caret-right){{ $field->getTitle() }}
                </div>
            @endforeach
            @foreach($data['models'] as $model)
                <div class="text-gray-700">
                    <x-ui::a href="{{route('thrust.edit', [$data['resource']->name(), $model->id])}}" class="showPopup">
                        {{ $model->name ?? "something" }}
                    </x-ui::a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>