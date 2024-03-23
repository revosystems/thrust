<div class="flex flex-col divide-y mt-4 gap-2">
    @forelse($found as $data)
        <div class="py-2">
            <div class="font-semibold mb-2">
                @if($data['resource'] instanceof \BadChoice\Thrust\ChildResource)
                    <div class="p-1">
                        {{ $data['resource']->getTitle() }}
                    </div>
                @elseif(isset($data['link']))
                    <div class="hover:bg-neutral-50 rounded p-1">
                        <a href="{{$data['link']}}">
                            <div class="flex items-center justify-between">
                                <div>{{$data['title']}}</div>
                                <div class="text-sm text-gray-400">@icon(arrow-right)</div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="hover:bg-neutral-50 rounded p-1">
                        <a href="{{route('thrust.index', $data['resource']->name())}}">
                            <div class="flex items-center justify-between">
                                <div>{{ $data['resource']->getTitle() }}</div>
                                <div class="text-sm text-gray-400">@icon(arrow-right)</div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
            @foreach($data['fields'] as $field)
                <div class="text-gray-400 p-1">
                    @icon(caret-right){{ $field->getTitle() }}
                </div>
            @endforeach
            @foreach($data['models'] as $model)
                <div class="text-gray-700 hover:bg-neutral-50 rounded p-1">
                    <x-ui::a href="{{route('thrust.edit', [$data['resource']->name(), $model->id])}}" class="showPopup">
                        {{ $model->name ?? "something" }}
                    </x-ui::a>
                </div>
            @endforeach
        </div>
    @empty
        <div class="py-4">
            <span class="text-gray-400">
                @icon(search) {{ __('thrust::messages.globalSearchNoResultsFor') }}
            </span>
            <span>
                `{{ request('search') }}`
            </span>
        </div>
    @endforelse
</div>