<div id="{{$id}}" class="border-t py-4">
    <div class="py-2">
        <x-ui::icon>{{$icon}}</x-ui::icon> {{ $title }}
    </div>
    <x-thrust::fields.edit-fields :object="$object" :fields="$fields" />
</div>