@props(['field', 'inlineCreationData'])

<x-ui::secondary-button class="thrust-inline-creation-button" onclick="thrustCreateInline{{$field}}()">
    @icon(plus)
</x-ui::secondary-button>

<script>
    function thrustCreateInline{{$field}}() {
        $("#inline-creation-{{$field}}").toggle('fast')
        $("#inline-creation-{{$field}}").load('/thrust/{{$inlineCreationData['relationResource']}}/create?inline=true', function(){
            $('#inline-creation-{{$field}} form').on('submit', function(e){
                e.preventDefault()
                var form = $(this)
                var url  = form.attr('action')
                $.ajax({type: "POST", url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function(data) {
                        console.log("Thrust inline creation data:");
                        console.log(data);
                        $('#inline-creation-{{$field}}').hide('fast');
                        const id = data['id'];
                        const value = data['{{$inlineCreationData['relationDisplayField']}}']

                        document.getElementById('{{$field}}').value = id
                        document.getElementById('{{$field}}_div').querySelector('div .truncate').innerHTML = value
                    }
                });
            })
        })
    }
</script>