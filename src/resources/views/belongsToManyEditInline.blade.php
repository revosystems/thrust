@if ($sortable)
    <x-ui::table.cell class="sort action hide-mobile"></x-ui::table.cell>
@endif
<form action="{{route('thrust.update', [$resourceName, $object->id] )}}" id='thrust-form-{{$object->id}}' method="POST" onkeydown="console.log(event.key)">
    @if (! $belongsToManyField->hideName)
        <x-ui::table.cell>{{ $relatedName }}</x-ui::table.cell>
    @endif
    @foreach($belongsToManyField->objectFields as $field)
        <x-ui::table.cell></x-ui::table.cell>
    @endforeach
    @foreach($fields as $field)
        <x-ui::table.cell class="{{$field->rowClass}}">
            @if ($field->showInEdit)
                {!! $field->displayInEdit($object, true) !!}
            @endif
        </x-ui::table.cell>
    @endforeach
    <x-ui::table.cell colspan="2">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <input type="hidden" name="inline" value="1">
        <x-ui::tertiary-button onclick="submitInlineForm({{$object->id}}); event.preventDefault();" form="thrust-form-{{ $object->id }}">
            {{ __("thrust::messages.save") }}
        </x-ui::tertiary-button>
    </x-ui::table.cell>
</form>