<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">

    <x-ui::forms.translatable-text-input
            :id="$field"
            :name="$field"
            :icon="$icon"
            :values="$value"
            :languages="$languages"
            placeholder="{{$title}}" {{$attributes}}
            class="w-full"
            {{ $attributes }}
    />

</x-thrust::formField>