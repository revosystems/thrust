<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline">
    <x-ui::forms.text-input
            id="{{$field}}"
            name="{{$field}}"
            type="{{$type}}"
            value="{{$value}}"
            placeholder="{{$title}}"
            class="w-full"
            {{ $attributes }}
/>
</x-thrust::formField>