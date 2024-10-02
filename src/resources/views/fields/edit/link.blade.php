@props(['asButton' => false, 'class', 'url', 'text'])

<div class="py-4">
    <a href="{{ $url }}" @class(['w-fit group', $class, 'flex items-center gap-2 text-brand' => !$asButton]) {{$attributes}}>
        @if($asButton)
            <x-ui::secondary-button>
                {{ $text }}
            </x-ui::secondary-button>
        @else
            {{ $text }}
            <x-ui::icon class="group-hover:translate-x-1 transition-transform duration-300">arrow-right</x-ui::icon>
        @endif
    </a>
</div>