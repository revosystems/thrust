<div class="resourceSearch">
    <x-ui::forms.search-text-input
            id='searcher'
            placeholder="{{__('thrust::messages.search')}}"
            autofocus
            class="w-full"
            value="{{request('search')}}"
    />
</div>