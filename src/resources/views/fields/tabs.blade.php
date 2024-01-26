<div id="{{$id}}">

    <x-ui::tabs :tabCount="count($fields)">
        @php $index = 1 @endphp
        @foreach($fields as $tab)
            <x-slot :name="'header'.$index">
                {{ $tab->title }}
            </x-slot>
            <x-slot :name="'content'.$index">
                <x-thrust::fields.edit-fields :object="$object" :fields="$tab->fields" />
            </x-slot>
        @php $index++ @endphp
        @endforeach
    </x-ui::tabs>
</div>