<div class="resourceSearch grow">
    <x-ui::forms.search-text-input
            id='searcher'
            placeholder="{{__('thrust::messages.search')}}"
            autofocus
            class="grow"
            value="{{request('search')}}"
    />
</div>