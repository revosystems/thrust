<x-thrust::formField :field="$field" :title="$title" :description="$description ?? null" :inline="$inline" :aside="true">
    <x-ui::forms.switch id="{{$field}}" name="{{$field}}" :on="boolval($value)" :inverted="$inverted"/>
</x-thrust::formField>