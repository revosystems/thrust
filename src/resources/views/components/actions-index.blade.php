@props(['actions', 'resourceName'])
<div id="thrust-resource-actions">
    @foreach($actions->where('main', false) as $action)
        <div class="">
            @if (count($action->fields()) == 0)
                <x-ui::tertiary-button :icon="$action->icon" action="async () => {
                await runAction('{{ $action->getClassForJs() }}', '{{$action->needsConfirmation}}', '{{$action->needsSelection}}', '{{$action->getConfirmationMessage()}}')
            }">
                    {{ $action->getTitle() }}
                </x-ui::tertiary-button>
            @else
                <a href="{{route('thrust.actions.create',[$resourceName])}}?action={{get_class($action)}}" class='actionPopup'>
                    <x-ui::tertiary-button :icon="$action->icon" :async="false">
                        <div>{{ $action->getTitle() }}</div>
                    </x-ui::tertiary-button >
                </a>
            @endif
        </div>
    @endforeach
</div>
