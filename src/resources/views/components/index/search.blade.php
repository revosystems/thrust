@props(['resourceName'])
<div class="resourceSearch grow relative" x-data="{
    searchText : '{{request('search')}}',
    loading : false,
    ajaxSearch(){
        if (this.searchText.length >= {{ config('thrust.minSearchChars') }}) {
            this.loading = true
            let url = '/thrust/{{$resourceName}}/search/' + this.searchText + '?page={{request('page')}}'
            console.log(url)
            fetch(url)
                .then(response => response.text())
                .then(data => this.onLoaded(data));
        } else {
            this.loading = false
            document.getElementById('all').style.display = 'block'
            document.getElementById('results').style.display = 'none'
        }
    },
    onLoaded(data){
        this.loading = false
        document.getElementById('all').style.display = 'none'
        document.getElementById('results').style.display = 'block'
        document.getElementById('results').innerHTML = data
        addListeners()
    },
}" x-init="ajaxSearch">

    <x-ui::forms.search-text-input
            x-ref="searcher"
            placeholder="{{__('thrust::messages.search')}}"
            focusable="true"
            class="grow"
            x-model="searchText"
            x-on:input.debounce="ajaxSearch"
    />
    <div class="absolute top-2 right-8" x-show="loading" x-cloak>
        <x-ui::spinner></x-ui::spinner>
    </div>
</div>