<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <div class="flex flex-row items-center">
        <select id="{{$field}}" name="{{$field}}" class="">
            <option value="{{$value}}" selected>{{$name}}</option>
        </select>
        @if(isset($inlineCreation) && $inlineCreation)
            <div>
            @include('thrust::fields.inlineCreation')
            </div>
        @endif
    </div>
    @push('edit-scripts')
        <script>
            new RVAjaxSelect2('{{ route('thrust.relationship.search', [$resourceName, $id ?? 0, $relationship]) }}?allowNull={{$allowNull}}',{
                width: '100%',
                @if (isset($fullPage) && ! $fullPage) dropdownParent: $('{{config('thrust.popupId', '#popup')}}') @endif
            }).show('#{{$field}}');
        </script>
    @endpush
</x-thrust::formField>