<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <span id="rangeInput_{{$field}}">{{ $value }}</span> {{ $unit }}<br>
    <input id="{{$field}}" name='{{$field}}' type="range" {{$attributes}} value="{{$value}}"
           onchange="$('#rangeInput_{{$field}}').text(this.value);"
           class="w-full"
    />
</x-thrust::formField>