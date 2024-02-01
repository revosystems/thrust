    @if ($fullPage)
        <div class="flex items-center space-x-2">
            @component(config('thrust.sidebar-collapsed-button'))@endcomponent
	        <div>{{ $title }}</div>
        </div>
    @else
        <div class="flex space-x-2 items-center">
            @if($breadcrumbs)
                <span> {{ $breadcrumbs }} </span>
                <x-ui::icon class="text-gray-400 text-xs">chevron-right</x-ui::icon>
            @endif
            <h2> {{ $object->{$nameField} ?: __('thrust::messages.new') }} </h2>
        </div>
    @endif

    @if (isset($object->id) )
        <form action="{{route('thrust.update', [$resourceName, $object->id] )}}" id='thrust-form-{{$object->id}}' method="POST">
        {{ method_field('PUT') }}
    @else
        <form action="{{route($multiple ? 'thrust.store.multiple' : 'thrust.store', [$resourceName] )}}" method="POST">
    @endif
    {{ csrf_field() }}

    {{-- Fields --}}
    <div>
        <x-thrust::fields.edit-fields :object="$object" :fields="$fields" />
        @includeWhen($multiple, 'thrust::quantityInput')
    </div>

    {{-- SAVE BUTTONS --}}
    <div class="mt-4 border-t pt-4">
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
            width: '300px',
            dropdownAutoWidth : true,
            @if (! $fullPage) dropdownParent: $('{{config('thrust.popupId', '#popup')}}') @endif
        });
        function initSelect2(){
            $('.searchable').select2({
                width: '300px',
                dropdownAutoWidth : true,
                @if (! $fullPage) dropdownParent: $('{{config('thrust.popupId', '#popup')}}') @endif    
            });
        }
        setupVisibility({!! json_encode($hideVisibility)  !!}, {!! json_encode($showVisibility)  !!});
    </script>

    <script>
        /*Array.from(document.getElementsByClassName('formTab')).forEach(function(element){
            document.getElementById('thrust-tabs-list').insertAdjacentHTML('beforeend', "<li class='thrust-tab-header " + element.id + "' onclick='showTab(this, \"" + element.id +"\")'>" + element.title + "</li>")
        })

        document.getElementsByClassName('thrust-tab-header').item(0)?.classList?.add('active')
        document.getElementsByClassName('formTab').item(0)?.classList?.add('active')

        function showTab(header, tabId){
            const newTab = document.getElementById(tabId)
            const oldTab = document.getElementsByClassName('formTab active').item(0)

            oldTab.style.display = 'none'
            oldTab.classList.remove('active')
            newTab.style.display = 'block'
            newTab.classList.add('active')

            document.getElementsByClassName('thrust-tab-header active').item(0).classList.remove('active')
            header.classList.add('active')
        }

        Array.from(document.getElementsByTagName('input')).forEach(function(elem){
            elem.addEventListener('invalid', () => {
                const tab = elem.closest('.formTab')
                if (tab) {
                    showTab(document.getElementsByClassName('thrust-tab-header ' + tab.id).item(0), tab.id)
                }
            })
        })*/
    </script>
@endpush

@if(!$fullPage)
    @stack('edit-scripts')
@endif
