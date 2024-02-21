<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <x-ui::forms.text-input
            icon="{{$icon}}"
            id="{{$field}}"
            name="{{$field}}"
            type="{{$type}}"
            value="{{$value}}"
            placeholder="{{$title}}"
            class="w-full"
            {{ $attributes }}
/>
</x-thrust::formField>