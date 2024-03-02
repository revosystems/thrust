@props(['actions', 'resourceName'])
<div id="thrust-resource-actions">
    @foreach($actions->where('main', false) as $action)
        <div class="">
            @if (count($action->fields()) == 0)
                <x-ui::tertiary-button :icon="$action->icon" action="async () => {
                await runAction('{{ $action->getClassForJs() }}', '{{$action->needsConfirmation}}', '{{$action->needsSelection}}', '{{$action->getConfirmationMessage()}}')
            }">
                    <div class="flex items-center space-x-2">
                        @if($action->icon)<x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>@endif
                        {{ $action->getTitle() }}
                    </div>
                </x-ui::tertiary-button>
            @else
                <a href="{{route('thrust.actions.create',[$resourceName])}}?action={{get_class($action)}}" class='actionPopup'>
                    <x-ui::tertiary-button :async="false">
                        <div class="flex items-center space-x-2">
                            @if($action->icon)<x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>@endif
                            <div>{{ $action->getTitle() }}</div>
                        </div>
                    </x-ui::tertiary-button >
                </a>
            @endif
        </div>
    @endforeach
</div>
