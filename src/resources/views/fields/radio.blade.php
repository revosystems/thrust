<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <fieldset class="flex items-center space-x-4 min-w-60">
        @foreach($options as $key => $optionValue)
            <div class="flex flex-col space-y-2 items-center text-center">
                @if($images[$key])
                    <img src="{{url($images[$key])}}" class="h-12"/>
                @endif
                <div class="text-xs">{{ $optionValue }}</div>
                <input
                   type="radio"
                   name="{{$field}}"
                   @if($key == $value) checked @endif
                   value="{{$key}}"
                />
            </div>
        @endforeach
    </fieldset>
</x-thrust::formField>