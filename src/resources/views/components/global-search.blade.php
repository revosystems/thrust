<x-ui::command-modal focusable class="w-full sm:w-[600px] sm:max-h-[600px]">
    <x-slot name="trigger">
        {{ $slot }}
    </x-slot>
    <div x-data="{
            searchText:'',
            loading: false,
            open(){
                $data.show = true
                $nextTick(() => { $refs.search.focus() })
            },
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
        }"
         @keydown.window.prevent.ctrl.k="open()"
         @keydown.window.prevent.meta.k="open()"
    >
        <div class="relative">
            <x-ui::forms.search-text-input
                    x-ref="search"
                    placeholder="{{__('thrust::messages.search')}}"
                    autofocus
                    focusable
                    class="grow"
                    x-model="searchText"
                    x-on:input.debounce="ajaxSearch"
            />
            <div class="absolute top-2 right-8" x-show="loading">
                <x-ui::spinner></x-ui::spinner>
            </div>
        </div>
        <div x-ref="results" class="lg:min-w-lg xl:min-w-xl max-h-[90%] overflow-scroll">
{{--            <div class="py-4 text-gray-400 flex justify-center items-center">--}}
{{--                <span>@icon(search) Search something interesting</span>--}}
{{--            </div>--}}
        </div>
    </div>
</x-ui::command-modal>