<form action="{{$link}}" method="post" x-data @submit.prevent="if (confirm('{{$confirm}}')) $el.submit()">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <x-ui::tertiary-button :async="true" type="submit" x-ref="button">
        <div class="flex items-center space-x-2">
            @if($icon) <x-ui::icon>{{$icon}}</x-ui::icon>@endif
            @if($title)<div class="hidden sm:block">{{ $title }}</div>@endif
        </div>
    </x-ui::tertiary-button>
</form>