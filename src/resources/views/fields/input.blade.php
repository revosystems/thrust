<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline">
    <x-ui::forms.text-input
            type="{{$type}}"
            id="{{$field}}"
            value="{{$value}}"
            name="{{$field}}"
            placeholder="{{$title}}"
            {{--{!! $fieldAttributes !!}
            {!! $validationRules !!} --}}
/>
</x-thrust::formField>