<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">

    <x-ui::forms.multiple-select id="{{$field}}" name="{{$field}}[]" :searchable="$searchable" class="w-full" :icon="$icon">
        @foreach($options as $key => $optionValue)
            <option @if($value && in_array($key, (array)$value)) selected @endif value="{{$key}}">{{$optionValue}}</option>
        @endforeach
    </x-ui::forms.multiple-select>

    @if($clearable)
        <x-ui::secondary-button id="{{$field}}_clear_selection" name="clear_selection">{{__('thrust::messages.clearSelection')}}</x-ui::secondary-button>
        <script>
        $('#{{$field}}_clear_selection').click(function() {
            $('#{{$field}} option').prop('selected', false);
            $('#{{$field}}').trigger('change');
        });
        </script>
    @endif

</x-thrust::formField>