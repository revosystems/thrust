@if (isset($inline) && $inline)
    <div style="display:inline-block;">
        {{ $slot }}
    </div>
@else
    <div id="{{$field}}_div"
        @class([
            'w-full flex py-4 first:pt-0 last:pb-0 flex-col gap-y-2 gap-x-4',
            'sm:flex-row sm:items-center sm:justify-between' => isset($aside) && $aside
        ])
        >
        <div @class([
            "field flex flex-col gap-1",
            "w-full" => !(isset($aside) && $aside),
        ])>
            <label class="font-semibold" for="{{$field}}">
                {{ $title }}
            </label>
            @if (isset($description) && $description)
                <p class="text-gray-400">{!! $description !!}</p>
            @endif
            @if(isset($learnMoreUrl) && $learnMoreUrl)
                <x-ui::learn-more href="{{$learnMoreUrl}}" :withIcon="true">
                    {{ __('thrust::messages.learnMore') }}
                </x-ui::learn-more>
            @endif
        </div>
        <div @class([
            "min-w-36 text-right" => (isset($aside) && $aside)
        ])>
            {{ $slot }}
        </div>
    </div>
@endif