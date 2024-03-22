<div class="flex flex-col divide-y mt-4 gap-2">
    @foreach($found as $data)
        <div class="py-2">
            <div class="font-semibold text-lg">
                <a href="{{route('thrust.index', $data['resource']->name())}}">
                    {{ $data['resource']->getTitle() }}
                </a>
            </div>
            @foreach($data['fields'] as $field)
                <div class="text-gray-400">
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