<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    @if($type == 'password')
        <x-ui::forms.password
                icon="{{$icon}}"
                id="{{$field}}"
                name="{{$field}}"
                type="{{$type}}"
                value="{{$value}}"
                placeholder="{{$title}}"
                class="w-full"
                {{ $attributes }}
        />
    @else
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
    @endif
</x-thrust::formField>
