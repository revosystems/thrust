@props(['actions', 'resourceName'])
<div>
    @foreach($actions->where('main', false) as $action)
        <div class="">
            @if (count($action->fields()) == 0)
                <x-ui::tertiary-button action="async () => {
                await runAction('{{ $action->getClassForJs() }}', '{{$action->needsConfirmation}}', '{{$action->needsSelection}}', '{{$action->getConfirmationMessage()}}')
            }">
                    <div class="flex items-center space-x-2">
                        <x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>
                        <div>{{ $action->getTitle() }}</div>
                    </div>
                </x-ui::tertiary-button>
            @else
                <a href="{{route('thrust.actions.create',[$resourceName])}}?action={{get_class($action)}}">
                    <x-ui::tertiary-button class='actionPopup' :async="false">
                        <div class="flex items-center space-x-2">
                            <x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>
                            <div>{{ $action->getTitle() }}</div>
                        </div>
                    </x-ui::tertiary-button >
                </a>
            @endif
        </div>
    @endforeach
</div>
