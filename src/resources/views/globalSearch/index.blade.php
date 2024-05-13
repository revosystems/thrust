<div class="flex flex-col divide-y mt-4 gap-2">
    @forelse($found as $data)
        <div class="py-2">
            <div class="font-semibold text-lg mb-2">
                @if($data['resource'] instanceof \BadChoice\Thrust\ChildResource)
                    {{ $data['resource']->getTitle() }}
                @elseif(isset($data['link']))
                    <a href="{{$data['link']}}" class="cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>{{$data['title']}}</div>
                            <div class="text-sm text-gray-400">@icon(arrow-right)</div>
                        </div>
                    </a>
                @else
                    <a href="{{ $data['resource']->indexUrl() }}" class="cursor-pointer">
                        <div class="flex items-center justify-between">
                            <div>{{ $data['resource']->getTitle() }}</div>
                            <div class="text-sm text-gray-400">@icon(arrow-right)</div>
                        </div>
                    </a>
                @endif
            </div>

            @foreach($data['fields'] as $field)
                <div class="py-1">
                    @if($data['resource']::$singleResource)
                        <a class="cursor-pointer" href="{{ $data['resource']->indexUrl() }}?#{{ $field->field }}_div">
                            @icon(caret-right){{ $field->getTitle() }}
                        </a>
                    @else
                        <span class="text-gray-400">
                            @icon(caret-right){{ $field->getTitle() }}
                        </span>
                   @endif
                </div>
            @endforeach
            @foreach($data['models'] as $model)
                <div class="text-gray-700">
                    <x-ui::a href="{{ $data['resource']->editUrl($model) }}" class="showPopup">
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