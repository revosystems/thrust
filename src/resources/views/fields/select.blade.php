<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline">
    <x-ui::forms.select id="{{$field}}" name="{{$field}}" >
        @if (isset($hasCategories) && $hasCategories))
        @foreach($options as $category => $values)
            <optgroup label="{{$category}}">
                @foreach($values as $key => $optionValue)
                    <option @if((! $key && $key === 0) || $key == $value) selected @endif value="{{$key}}">{{$optionValue}}</option>
                @endforeach
            </optgroup>
        @endforeach
        @else
            @foreach($options as $key => $optionValue)
                <option @if((! $key && $key === 0) || $key == $value) selected @endif value="{{$key}}">{{$optionValue}}</option>
            @endforeach
        @endif
    </x-ui::forms.select>
    @if(isset($inlineCreation) && $inlineCreation)
        <x-thrust::fields.inlineCreation :field="$field" :inlineCreationData="$inlineCreationData" />
    @endif
</x-thrust::formField>