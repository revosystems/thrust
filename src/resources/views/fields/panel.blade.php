<div id="{{$id}}" class="py-4">
    @if($title)
        <div class="py-2 text-lg mb-2">
            @if($icon)
                <x-ui::icon class="text-gray-400 mr-1">{{$icon}}</x-ui::icon>
            @endif
            {{ $title }}
        </div>
    @endif
    @if($description)
        <div class="flex items-center space-x-4 mb-2">
            @if($descriptionIcon)
                <x-ui::icon class="text-gray-700">{{$descriptionIcon}}</x-ui::icon>
            @endif
            <div class="py-2 text-gray-400 text-sm">
                {{$description}}
            </div>
        </div>
    @endif
    <x-thrust::fields.edit-fields :object="$object" :fields="$fields" />

</div>