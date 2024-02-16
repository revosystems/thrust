<x-thrust::formField :field="$field" :title="$title" :description="$description ?? null" :inline="$inline" :aside="true" :learnMoreUrl="$learnMoreUrl">
{{--    <input type="hidden" value="0" name="{{$field}}">--}}
{{--    <input type="checkbox" id="{{$field}}" @if($value) checked @endif value="1" name="{{$field}}">--}}
    <x-ui::forms.switch id="{{$field}}" name="{{$field}}" :on="boolval($value)" />
</x-thrust::formField>