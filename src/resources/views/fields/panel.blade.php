<div id="{{$id}}" class="formPanel">
    @if($icon)
        <x-ui::icon>{{$icon}}</x-ui::icon>
    @endif
    {{ $title }}
    <div >
        <x-thrust::fields.edit-fields :object="$object" :fields="$fields" />
    </div>
</div>