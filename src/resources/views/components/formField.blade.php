@if (isset($inline) && $inline)
    <div style="display:inline-block;">
        {{ $slot }}
    </div>
@else
    <div id="{{$field}}_div"
        @class([
            'w-full flex py-4',
            'flex-col' => !(isset($aside) && $aside),
            'flex-col sm:flex-row sm:items-center sm:space-x-4 sm:justify-between' => isset($aside) && $aside
        ])
        >
        <div @class([
            "field flex flex-col",
            "w-full" => !(isset($aside) && $aside),
        ])>
            <div class="font-semibold">
                {{ $title }}
            </div>
            <div class="flex flex-col ">
                @if (isset($description))
                    <div class="text-gray-400 mt-1 mb-2">{!! $description !!}</div>
                @endif
            </div>
            @if(isset($learnMoreUrl) && $learnMoreUrl)
                <div class="my-1">
                    <x-ui::learn-more href="{{$learnMoreUrl}}" :withIcon="true">
                        {{ __('thrust::messages.learnMore') }}
                    </x-ui::learn-more>
                </div>
            @endif
        </div>
        <div @class([
            "min-w-36",
            "text-right" => (isset($aside) && $aside)
        ])>
            {{ $slot }}
        </div>
    </div>
@endif