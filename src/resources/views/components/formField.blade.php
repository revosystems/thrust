@if (isset($inline) && $inline)
    <div class="inline-block">
        {{ $slot }}
    </div>
@else
    <div class='formField' id="{{$field}}_div">
        <div class="label">{{ $title }}</div>
        <div class="field">
            {{ $slot }}
            @if (isset($description))
                <p>{!! $description !!}</p>
            @endif
        </div>
    </div>
@endif