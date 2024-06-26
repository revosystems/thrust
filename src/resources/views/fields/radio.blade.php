<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <fieldset class="flex items-center space-x-10 min-w-60">
        @foreach($options as $key => $optionValue)
            <div class="flex flex-col space-y-4 items-start text-center">
                <label for="{{$field}}-{{$key}}">
                    @if($images[$key])
                        <img src="{{url($images[$key])}}" class="h-20 rounded shadow-sm"  />
                    @endif
                </label>

                <div class="flex space-x-2">
                    <input type="radio" name="{{$field}}" id="{{$field}}-{{$key}}" value="{{$key}}" @if($key == $value) checked @endif/>
                    <div class="flex flex-col items-start">
                        <div class="text-xs">{{ $optionValue }}</div>
                        @if($optionDescription = $descriptions[$key])
                            <div class="text-xs text-gray-400 text-left">{{ $optionDescription }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </fieldset>
</x-thrust::formField>