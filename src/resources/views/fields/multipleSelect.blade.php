<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <input hidden name="{{$field}}" value="">
    <select id="{{$field}}" name="{{$field}}[]" @if($searchable) class="searchable w-full" @endif multiple>
        @foreach($options as $key => $optionValue)
            <option @if($value && in_array($key, (array)$value)) selected @endif value="{{$key}}">{{$optionValue}}</option>
        @endforeach
    </select>
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