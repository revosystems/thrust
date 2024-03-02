<x-ui::breadcrums :data="[
    $action->getTitle()
]"/>

<form action="{{route('thrust.actions.perform', [$resourceName])}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="ids" value="{{request('ids')}}">
    <input type="hidden" name="action" value="{{get_class($action)}}">

    <div class="flex flex-col divide-y divide-gray-100">
        @foreach($action->fields() as $field)
            {!! $field->displayInEdit(null) !!}
        @endforeach
    </div>

    <x-ui::primary-button :async="true" type="submit">
        {{ __("thrust::messages.perform") }}
    </x-ui::primary-button>
</form>

<script>
    $('.searchable').select2({
        //width: '300px',
        dropdownAutoWidth : true,
        dropdownParent: $('{{config('thrust.popupId', '#popup')}}')
    });
</script>
