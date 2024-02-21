<h2> {{$title}} </h2>

<div class="flex justify-between items-center space-x-2">
    <x-ui::forms.search-text-input id='popup-searcher'
                                   :placeholder="__('thrust::messages.search')"
                                   class="w-full"
                                   autofocus />
    @if($sortable)
        <div class="actions">
            <x-ui::secondary-button onclick="saveChildOrder('{{$resourceName}}','{{$object->id}}', '{{$belongsToManyField->field}}')">
                @icon(sort)
                {{__('thrust::messages.saveOrder')}}
            </x-ui::secondary-button>
        </div>
    @endif
</div>
<div id="popup-all" class="mt-4">
    @include('thrust::belongsToManyTable')
</div>
<div id="popup-results"></div>

@if (app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'create'))
    <div class="mt4">
        <form id='belongsToManyForm' action="{{route('thrust.belongsToMany.store', [$resourceName, $object->id, $belongsToManyField->field]) }}" method="POST">
            {{ csrf_field() }}
            <div class="flex items-center space-x-2">
                <select id="id" name="id" @if($belongsToManyField->searchable) class="searchable" @endif >
                    @if (!$ajaxSearch)
                        @foreach($belongsToManyField->getOptions($object) as $possible)
                            <option value='{{$possible->id}}'> {{ $possible->name }} </option>
                        @endforeach
                    @endif
                </select>
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
@endif

<script>
    $("{{config('thrust.popupId', '#popup')}} .thrust-toggle").each(function(index, el){
        $(el).addClass('ajax-get');
    });
    
    addListeners();
    // $('#popup > select > .searchable').select2({ width: '325', dropdownAutoWidth : true });
    @if ($searchable && !$ajaxSearch)
    $('.searchable').select2({
        //width: '300px',
        dropdownAutoWidth : true,
        dropdownParent: $('{{config('thrust.popupId', '#popup')}}'),
    });
    @endif

    $('#popup-searcher').searcher('/thrust/{{$resourceName}}/{{$object->id}}/belongsToMany/{{$belongsToManyField->field}}/search/', {
        'resultsDiv' : 'popup-results',
        'allDiv' : 'popup-all',
        'updateAddressBar' : false,
        'onFound' : function(){
            addListeners();
        }
    });

    @if ($ajaxSearch)
    new RVAjaxSelect2('{{ route('thrust.relationship.search', [$resourceName, $object->id, $belongsToManyField->field]) }}?allowNull=0&allowDuplicates={{$allowDuplicates}}',{
        dropdownParent: $('{{config('thrust.popupId', '#popup')}}'),
    }).show('#id');
    @endif

    popupUrl = "{{route('thrust.belongsToMany', [$resourceName, $object->id, $belongsToManyField->field]) }}";
    $('#belongsToManyForm').on('submit', function(e){
        e.preventDefault();
        $.post($(this).attr('action'), $(this).serialize()).done(function(){
            loadPopup(popupUrl)
        });
    });

    $("{{config('thrust.popupId', '#popup')}} .delete-resource").each(function(index, el){
        $(el).attr({
            'data-delete' : $(el).attr('data-delete') + ' ajax '
        });
    });

    $("{{config('thrust.popupId', '#popup')}} .sortableChild" ).sortable({
        axis: "y",
    });

    $("{{config('thrust.popupId', '#popup')}}  tr").on("dblclick", function(element){
        if ($(this).find("a.edit").length == 0) return;
        belongsToManyEditInline($(this).attr('id').replace("sort_", ""));
    });

    $("{{config('thrust.popupId', '#popup')}}  a.edit").on("click", function(element){
        belongsToManyEditInline($(this).attr('id').replace("edit_", ""));
    });

    function belongsToManyEditInline(id){
        var url = "{{route('thrust.belongsToMany.editInline', [$resourceName, $object->id, $belongsToManyField->field, 'pivotId'])}}".replace("pivotId", id);
        $(`#sort_${id}`).load(url, () => {
           $(`#sort_${id} input, #sort_${id} textarea, #sort_${id} select`).each((index, el)=>{ el.setAttribute('form', `thrust-form-${id}`)})
        });
    }
</script>