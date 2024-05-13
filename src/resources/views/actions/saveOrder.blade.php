<x-ui::secondary-button class="hidden sm:block" action="async () => saveOrder('{{$resourceName}}', {{ $startAt }} )">
    <div class="flex items-center space-x-2">
        <span>@icon(sort)</span>
        <span class="hidden md:block">{{ $title }}</span>
    </div>
</x-ui::secondary-button>