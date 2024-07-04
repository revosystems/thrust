@if ( method_exists($data, 'links')  && $data->lastPage() != 1)
    <div class="flex items-center gap-2 m-4">
        <div class="grow">
            @php(
                /*$data->withPath(Thrust::resourceNameFromModel($resource))*/
                ""
            )
            {{ $data->links() }}
        </div>
        <div x-data="">
            <x-ui::forms.select name="pagination" x-on:change="
                window.location = window.location.pathname + '?pagination=' + event.target.value;
            ">
                @foreach([25, 50, 100] as $value)
                    <option value="{{ $value }}" @if(request('pagination') == $value) selected @endif>{{ $value }}</option>
                @endforeach
            </x-ui::forms.select>
        </div>
    </div>
    @if(isset($popupLinks))
        <script>
            $(".page-link").on('click', function(e){
                e.preventDefault();
                loadPopup($(this).attr('href'));
            })
        </script>
    @endif
@endif