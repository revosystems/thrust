@if (isset($inline) && $inline)
    <div style="display:inline-block;">
        {{ $slot }}
    </div>
@else
    <div class='w-full flex flex-col sm:flex-row sm:items-center' id="{{$field}}_div">
        <div class="w-44">{{ $title }}</div>
        <div class="field flex flex-col grow w-full">
            {{ $slot }}
            @if (isset($description))
                <div class="text-gray-400">{!! $description !!}</div>
            @endif
        </div>
    </div>
@endif