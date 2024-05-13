@props(['object', 'fields', 'sideBySide' => false])
<div @class([
        'flex flex-col divide-y divide-gray-100',
        'sm:flex sm:flex-row sm:space-x-2 sm:divide-none' => $sideBySide,
])>
    @foreach($fields as $field)
        @if (! $field->shouldHide($object, 'edit') && $field->shouldShow($object, 'edit'))
            {!! $field->displayInEdit($object) !!}
        @endif
    @endforeach
</div>