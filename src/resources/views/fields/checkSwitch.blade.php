@component('thrust::components.formField', ["field" => $field, "title" => $title, "description" => $description ?? null, 'inline' => $inline])
    <input id="{{$field}}" type="hidden" value="{{$value?$value:'0'}}" name="{{$field}}">
    <i id="{{$field}}Switch" class="fa @if($value) fa-toggle-on green @else fa-toggle-off red o20 @endif" style="font-size:24px"></i>

    @push('edit-scripts')
        <script>
            $("#{{$field}}Switch").on('click', function(){
                if ($(this).hasClass('fa-toggle-on')) {
                    $(this).removeClass('fa-toggle-on green').addClass('fa-toggle-off red o20');
                    $('#{{$field}}').val('0').trigger('change');
                }
                else{
                    $(this).removeClass('fa-toggle-off red o20').addClass('fa-toggle-on green');
                    $('#{{$field}}').val('1').trigger('change');
                }
            });
        </script>
    @endpush

@endcomponent
