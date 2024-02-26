<x-ui::breadcrums :data="[$title]" />

<div class="flex justify-between items-center space-x-2 mt-4">
    <x-ui::forms.search-text-input id='popup-searcher'
                                   :placeholder="__('thrust::messages.search')"
                                   class="w-full" />
    @if($sortable)
        <x-ui::secondary-button onclick="saveChildOrder('{{$resourceName}}','{{$object->id}}', '{{$belongsToManyField->field}}')">
            <span class="text-gray-500">@icon(sort)</span>
            {{__('thrust::messages.saveOrder')}}
        </x-ui::secondary-button>
    @endif
</div>
<div id="popup-all" class="mt-4">
    @include('thrust::belongsToManyTable')
</div>
<div id="popup-results"></div>

@includeWhen(app(BadChoice\Thrust\ResourceGate::class)->can($pivotResourceName, 'create'),
    'thrust::belongsToManyIndexCreate'
)

<script>

    addListeners();

    $("{{config('thrust.popupId', '#popup')}} .thrust-toggle").each(function(index, el){
        $(el).addClass('ajax-get');
    });

    $('#popup-searcher').searcher('/thrust/{{$resourceName}}/{{$object->id}}/belongsToMany/{{$belongsToManyField->field}}/search/', {
        'resultsDiv' : 'popup-results',
        'allDiv' : 'popup-all',
        'updateAddressBar' : false,
        'onFound' : function(){
            addListeners();
        }
    });

    popupUrl = "{{route('thrust.belongsToMany', [$resourceName, $object->id, $belongsToManyField->field]) }}";


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
