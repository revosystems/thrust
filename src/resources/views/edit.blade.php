    @if ($fullPage)
        <div class="flex items-center mb-4 w-xl">
            @component(config('thrust.sidebar-collapsed-button'))@endcomponent
	        <h2>{{ $title }}</h2>
        </div>
    @else
        <div class="flex space-x-1 items-center text-lg pb-2">
            @if($breadcrumbs)
                 <x-ui::breadcrums :data="$breadcrumbs" />
                 <x-ui::icon class="text-gray-400 text-sm">chevron-right</x-ui::icon>
            @endif
            <span>{{ $object->{$nameField} ?: __('thrust::messages.new') }}</span>
        </div>
    @endif

    @if (isset($object->id) )
        <form action="{{route('thrust.update', [$resourceName, $object->id] )}}" id='thrust-form-{{$object->id}}' method="POST" enctype="multipart/form-data">
        {{ method_field('PUT') }}
    @else
        <form action="{{route($multiple ? 'thrust.store.multiple' : 'thrust.store', [$resourceName] )}}" method="POST" enctype="multipart/form-data">
    @endif
    {{ csrf_field() }}

    {{-- Fields --}}
    <div>
        <x-thrust::fields.edit-fields :object="$object" :fields="$fields" />
        @includeWhen($multiple, 'thrust::quantityInput')
    </div>

    {{-- SAVE BUTTONS --}}
    <div class="mt-4 pt-4">
        @if (isset($object->id))
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($resourceName, 'update', $object))
                <x-thrust::saveButton :updateConfirmationMessage="$updateConfirmationMessage" />
                <x-ui::secondary-button class="hidden" id="thrust-save-and-continue" onclick="submitAjaxForm('thrust-form-{{$object->id}}')">
                    {{ __("thrust::messages.saveAndContinueEditing") }}
                </x-ui::secondary-button>
            @endif
        @else
            @if (app(BadChoice\Thrust\ResourceGate::class)->can($resourceName, 'create', $object))
                <x-thrust::saveButton :updateConfirmationMessage="$updateConfirmationMessage" />
            @endif
        @endif
    </div>

</form>


@push('edit-scripts')
    @if (! $fullPage)
        @include('thrust::components.js.saveAndContinue')
    @endif
    <script>
        $('.searchable').select2({
            //width: '300px',
            dropdownAutoWidth : true,
            @if (! $fullPage) dropdownParent: $('{{config('thrust.popupId', '#popup')}}') @endif
        });
        function initSelect2(){
            $('.searchable').select2({
                //width: '300px',
                dropdownAutoWidth : true,
                @if (! $fullPage) dropdownParent: $('{{config('thrust.popupId', '#popup')}}') @endif
            });
        }
        setTimeout(function(){  //Since it is called before alpine, we need to give it a $nextTick (delay)
            setupVisibility({!! json_encode($hideVisibility)  !!}, {!! json_encode($showVisibility)  !!});
        }, 10)

    </script>
@endpush

@if(!$fullPage)
    @stack('edit-scripts')
@else
    <div class="pb-8"></div>
@endif
