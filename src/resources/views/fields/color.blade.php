<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    @php $id = str_replace("]","-",str_replace("[", "", $field))  @endphp

    <div class="flex space-x-2 items-center">
        <input type="color" id="colorpicker-{{$id}}" value="{{$value}}" name="{{$field}}" placeholder="{{$title}}">
        <x-ui::forms.text-input id="{{$id}}" value="{{$value}}" name="{{$field}}" placeholder="{{$title}}" />
    </div>
    @push('edit-scripts')
        <script>
            $('#colorpicker-{{$id}}').on('change', function() {
                $('#{{$id}}').val(this.value); }
            );
        </script>
    @endpush
</x-thrust::formField>