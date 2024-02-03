<x-thrust::formField :field="$field" :title="$title" :description="$description">
    <x-ui::forms.textarea id="{{$field}}"
                    name="{{$field}}"
                    class="w-full"
                    placeholder="{{$title}}"
                    {{ $attributes }}
    >{{$value}}</x-ui::forms.textarea>
</x-thrust::formField>