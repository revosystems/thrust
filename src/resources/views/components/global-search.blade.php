<x-ui::command-modal focusable>
    <x-slot name="trigger">
        {{ $slot }}
    </x-slot>
    <div x-data="{
            searchText:'',
            loading: false,

            ajaxSearch(){
                    if (this.searchText.length >= {{ config('thrust.minSearchChars') }}) {
                    this.loading = true
                    let url = '/thrust/globalSearch?search=' + this.searchText
                    console.log(url)
                    fetch(url)
                        .then(response => response.text())
                        .then(data => this.onLoaded(data));
                } else {
                    this.loading = false
                    $refs.results.style.display = 'none'
                }
            },
            onLoaded(data){
                this.loading = false
                $refs.results.style.display = 'block'
                $refs.results.innerHTML = data
                addListeners()
            },
        }">
        <div class="relative">
            <x-ui::forms.search-text-input
                    placeholder="{{__('thrust::messages.search')}}"
                    autofocus
                    focusable
                    class="grow min-w-96"
                    x-model="searchText"
                    x-on:input.debounce="ajaxSearch"
            />
            <div class="absolute top-2 right-8" x-show="loading">
                <x-ui::spinner></x-ui::spinner>
            </div>
        </div>
        <div x-ref="results" class="min-w-lg">
            <div class="py-4 text-gray-400 flex justify-center items-center">
                <span>@icon(search) Search something interesting</span>
            </div>
        </div>
    </div>
</x-ui::command-modal>