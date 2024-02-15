@if (isset($inline) && $inline)
    <div style="display:inline-block;">
        {{ $slot }}
    </div>
@else
    <div id="{{$field}}_div"
        @class([
            'w-full flex py-4',
            'flex-col' => !isset($aside),
            'flex-row items-center space-x-4' => isset($aside)
        ])
        >
        <div class="field flex flex-col grow w-full">
            <div class="font-semibold">
                {{ $title }}
            </div>
            <div class="flex flex-col grow">
                @if (isset($description))
                    <div class="text-gray-400 mt-1 mb-2">{!! $description !!}</div>
                @endif
            </div>
        </div>
        <div class="">
            {{ $slot }}
        </div>
    </div>
@endif