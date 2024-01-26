@props(['actions', 'resourceName'])
<div>
@foreach($actions->where('main', false) as $action)
    <div class="">
        @if (count($action->fields()) == 0)
            <x-ui::tertiary-button onclick='runAction("{{ $action->getClassForJs() }}", "{{$action->needsConfirmation}}", "{{$action->needsSelection}}", "{{$action->getConfirmationMessage()}}")'>
                <div class="flex items-center space-x-2">
                    <x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>
                    <div>{{ $action->getTitle() }}</div>
                </div>
            </x-ui::tertiary-button>
        @else
            <x-ui::tertiary-button class='actionPopup' href="{{route('thrust.actions.create',[$resourceName])}}?action={{get_class($action)}}">
                <div class="flex items-center space-x-2">
                    <x-ui::icon class="text-gray-700">{{$action->icon}}</x-ui::icon>
                    <div>{{ $action->getTitle() }}</div>
                </div>
            </x-ui::tertiary-button >
        @endif
    </div>
@endforeach
</div>
