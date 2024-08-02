<x-ui::modal.bottom maxWidth="{{$message ? 'xl' : 'sm'}}">
    <x-slot name="trigger">
        <x-ui::tertiary-button type="button">
            <div class="flex items-center space-x-2">
                @if($icon) <x-ui::icon>{{$icon}}</x-ui::icon>@endif
                @if($title)<div class="hidden sm:block">{{ $title }}</div>@endif
            </div>
        </x-ui::tertiary-button>
    </x-slot>

    <div class="relative p-4">
        <form action="{{$link}}" method="post">
            @csrf()
            @method('DELETE')
            <x-ui::h2 class="mb-4">{{ $confirm }}</x-ui::h2>
            
            @if ($message)
                <p class="mb-8">{{ $message }}</p>
            @endif

            <div class="flex justify-center gap-4 items-center">
                <x-ui::secondary-button type="button" x-on:click="show=false">{{ __('admin.cancel') }}</x-ui::secondary-button>
                <x-ui::primary-button type="submit" :async="true" x-ref="button" autofocus>{{ __('thrust::messages.delete') }}</x-ui::primary-button>
            </div>
        </form>
    </div>
</x-ui::modal.bottom>