<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <div class="flex flex-col">
        <div class="flex items-center space-x-2">
            <x-ui::forms.searchable-select id="{{$field}}" name="{{$field}}" class="w-full" :icon="$icon ?? null">
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
            </x-ui::forms.searchable-select>
            @if($inlineCreation ?? false)
            <div>
                <x-thrust::fields.inlineCreationButton  :field="$field" :inlineCreationData="$inlineCreationData" />
            </div>
            @endif
        </div>
        @if($inlineCreation ?? false)
        <div>
            <x-thrust::fields.inlineCreation        :field="$field" :inlineCreationData="$inlineCreationData" />
        </div>
        @endif
    </div>
</x-thrust::formField>