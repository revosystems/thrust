@props(['actions', 'resourceName'])
@if (count($actions) > 0)
    @if ($actions->where('main', false)->count() > 0)
        <x-ui::dropdown :offset="14" :arrow="true">
            <x-slot name="trigger">
            <x-ui::secondary-button>
                <i id='actions-loading' class="fa fa-circle-o-notch fa-spin fa-fw" style="display:none"></i>
                <div class="sm:hidden">
                    <x-ui::icon>ellipsis</x-ui::icon>
                </div>
                <div class="hidden sm:block">
                    {{ __("thrust::messages.actions") }} @icon(caret-down)
                </div>
                </x-ui::secondary-button>
            </x-slot>
            <x-thrust::actionsIndex :actions="$actions" :resourceName="$resourceName" />
        </x-ui::dropdown>
    @endif

    @foreach( $actions->where('main', true) as $action)
        <x-ui::secondary-button class="secondary" onclick='runAction("{{ $action->getClassForJs() }}", "{{$action->needsConfirmation}}", "{{$action->needsSelection}}", "{{$action->getConfirmationMessage()}}")'>
            <x-ui::icon>{{$action->icon}}</x-ui::icon>
        </x-ui::secondary-button>
    @endforeach

@endif
