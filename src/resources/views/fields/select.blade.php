<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <div class="flex flex-col">
        <div class="flex items-center space-x-2">
            <x-ui::forms.searchable-select :id="$field" :name="$field" :icon="$icon ?? null" :searchable="$searchable" :disabled="$attributes->get('disabled', false)" class="w-full" {{ $attributes }}>
                @if (isset($hasCategories) && $hasCategories))
                @foreach($options as $category => $values)
                    <optgroup label="{{$category}}">
                        @foreach($values as $key => $optionValue)
                            <option @if(!is_null($value) && $key == $value) selected @endif
                                    value="{{$key}}"
                                    description="{{$descriptions[$key] ?? ""}}"
                            >
                                {{$optionValue}}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
                @else
                    @foreach($options as $key => $optionValue)
                        <option @if(!is_null($value) && $key == $value) selected @endif
                            value="{{$key}}"
                            description="{{$descriptions[$key] ?? ""}}"
                        >
                            {{$optionValue}}
                        </option>
                    @endforeach
                @endif
            </x-ui::forms.searchable-select>
        </div>
    </div>
</x-thrust::formField>