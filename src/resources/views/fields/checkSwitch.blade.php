<x-thrust::formField :field="$field" :title="$title" :description="$description ?? null" :inline="$inline">
    <x-ui::forms.switch id="{{$field}}" name="{{$field}}" :on="boolval($value)" />
</x-thrust::formField>