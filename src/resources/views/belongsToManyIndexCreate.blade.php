<div class="mt-4 pt-4 border-t">
    <form id='belongsToManyForm' action="{{route('thrust.belongsToMany.store', [$resourceName, $object->id, $belongsToManyField->field]) }}" method="POST">
        {{ csrf_field() }}
        <div class="flex items-center space-x-2">

            @if ($ajaxSearch)
                <x-ui::forms.ajax-searchable-select
                        id="id"
                        name="id"
                        :allowNull="false"
                        :url="route('thrust.relationship.search', [$resourceName, $object->id, $belongsToManyField->field]).'?allowDuplicates=true'"
                />
            @else
                <x-ui::forms.searchable-select id="id" name="id">
                    @foreach($belongsToManyField->getOptions($object) as $possible)
                        <option value='{{$possible->id}}'> {{ $possible->name }} </option>
                    @endforeach
                </x-ui::forms.searchable-select>
            @endif

            @foreach($belongsToManyField->pivotFields as $field)
                @if($field->showInEdit && $resource->can($field->policyAction))
                    {!! $field->displayInEdit(null, true)  !!}
                @endif
            @endforeach
            <x-ui::secondary-button type="submit">
                <div class="flex items-center space-x-2">
                    <span>@icon(plus)</span><span class="hidden sm:block">{{__('thrust::messages.add') }}</span>
                </div>
            </x-ui::secondary-button>
        </div>

    </form>
</div>

<script>
    $('#belongsToManyForm').on('submit', function(e){
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize()).done(function(){
            loadPopup(popupUrl)
        });
    });
</script>