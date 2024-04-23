<div id="{{$id}}">

    <x-ui::tabs :tabCount="count($fields)">
        @php $index = 1 @endphp
        @foreach($fields as $tab)
            <x-slot :name="'header'.$index">
                @if ($tab->icon)
                    <x-ui::tooltip>
                        <x-slot name="trigger">
                            <x-ui::icon>{{$tab->icon}}</x-ui::icon>
                        </x-slot>
                        {{ $tab->title }}
                    </x-ui::tooltip>
                @else
                    {{ $tab->title }}
                @endif

            </x-slot>
            <x-slot :name="'content'.$index">
                <div class="text-lg my-2">{{ $tab->title }}</div>
                <x-thrust::fields.edit-fields :object="$object" :fields="$tab->fields" />
            </x-slot>
            @php $index++ @endphp
        @endforeach
    </x-ui::tabs>
</div>