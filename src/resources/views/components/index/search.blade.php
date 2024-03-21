@props(['resourceName'])
<div class="resourceSearch grow relative" x-data="{
    searchText : '',
    loading : false,
    ajaxSearch(){
        if(this.searchText.length >= {{ config('thrust.minSearchChars') }}) {
            this.loading = true
            let url = '/thrust/{{$resourceName}}/search/' + this.searchText
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
    }
}">

    <x-ui::forms.search-text-input
            x-ref="searcher"
            placeholder="{{__('thrust::messages.search')}}"
            autofocus
            class="grow"
            x-model="searchText"
            x-on:input.debounce="ajaxSearch"
            :value="request('search')"
    />
    <div class="absolute top-2 right-8" x-show="loading">
        <x-ui::spinner></x-ui::spinner>
    </div>
</div>