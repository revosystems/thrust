@if ( method_exists($data, 'links')  && $data->lastPage() != 1)
    <div class="m-4">
        @php(
            /*$data->withPath(Thrust::resourceNameFromModel($resource))*/
            ""
        )
        {{ $data->links() }}
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