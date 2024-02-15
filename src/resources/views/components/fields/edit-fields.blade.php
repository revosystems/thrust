@props(['object', 'fields'])
<div class="flex flex-col divide-y divide-gray-100">
    @foreach($fields as $field)
        @if (! $field->shouldHide($object, 'edit') && $field->shouldShow($object, 'edit'))
            {!! $field->displayInEdit($object) !!}
        @endif
    @endforeach
</div>