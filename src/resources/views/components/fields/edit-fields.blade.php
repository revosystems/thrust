@props(['object', 'fields'])
<div class="flex flex-col space-y-4">
    @foreach($fields as $field)
        @if (! $field->shouldHide($object, 'edit') && $field->shouldShow($object, 'edit'))
            {!! $field->displayInEdit($object) !!}
        @endif
    @endforeach
</div>