<div id="{{$id}}">

    <x-ui::tabs :tabCount="count($fields)">
        @php $index = 1 @endphp
        @foreach($fields as $tab)
            <x-slot :name="'header'.$index">
                @if($tab->icon)
                    <div class="flex items-center gap-1">
                        <x-ui::icon>{{$tab->icon}}</x-ui::icon> <div class="hidden md:block">{{ $tab->title }}</div>
                    </div>
                @else
                    {{ $tab->title }}
                @endif

            </x-slot>
            <x-slot :name="'content'.$index">
                <x-thrust::fields.edit-fields :object="$object" :fields="$tab->fields" />
            </x-slot>
        @php $index++ @endphp
        @endforeach
    </x-ui::tabs>
</div>