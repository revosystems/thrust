@if(count($resource->singleResourceActions()))
    <x-ui::dropdown>
        <x-slot:trigger>
            <x-ui::secondary-button>@icon(ellipsis-v)</x-ui::secondary-button>
        </x-slot:trigger>
        <div class="flex flex-col gap-2">
            @foreach($resource->singleResourceActions() as $action)
                <x-ui::tertiary-button :icon="$action->icon" action="function() { doSingleResourceAction('{{ $action->getClassForJs() }}') }">
                    {{ $action->title }}
                </x-ui::tertiary-button>
            @endforeach
        </div>
    </x-ui::dropdown>

    <script>
    async function doSingleResourceAction(actionClass){
        await $.post("{{ route('thrust.actions.singleResource.perform', [$resourceName]) }}", {
            "_token": "{{ csrf_token() }}",
            "action" : actionClass,
        }).done(function(data){
            if (data["responseAsPopup"]){
                $('#popup').popup('show')
                $("#popupContent").html(data["message"])
            } else {
                showMessage(data["message"])
            }
            if (data["shouldReload"]) {
                location.reload()
            }
        }).fail(function(){
            showMessage("Something went wrong")
        })
    }
</script>

@endif

