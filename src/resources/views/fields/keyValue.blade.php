@component('thrust::components.formField', ["field" => $field, "title" => $title, "description" => $description ?? null, "inline" => $inline])
    <input type="hidden" name="{{$field}}" value="">
    <script type="template/html" id="template-{{$field}}">
        {{--    <template id="template-{{$field}}">--}}
                <div id="keyValue-template" class="keyValueField-{{$field}} w-full flex gap-2 items-center">
                    <div class="flex gap-2 items-center flex-wrap grow sm:grow-0" id="keyValueFields-template">
                        <div id="key" @class(['basis-full sm:basis-auto', 'grow' => $keyValueField->keyOptions])>
                            @if(! $keyValueField->keyOptions) 
                                <x-ui::forms.text-input id="templateID" name="templateID" placeholder='key' class="w-full" />
                            @else
                                <x-ui::forms.select id="templateID" name="templateID" class="w-full sm:min-w-40">
                                    {!! $keyValueField->generateOptions($keyValueField->keyOptions, null) !!}
                                </x-ui::forms.select>
                            @endif
                        </div>
                        <div id="value" @class(['basis-full sm:basis-auto', 'grow' => $keyValueField->valueOptions])>
                            @if(! $keyValueField->valueOptions)
                                <x-ui::forms.text-input id="templateID" name="templateID" placeholder='value' class="w-full" />
                            @elseif($multiple)
                                <x-ui::forms.multiple-select id="templateID" name="templateID" class="w-full sm:min-w-40">
                                    {!! $keyValueField->generateOptions($keyValueField->valueOptions, null) !!}
                                </x-ui::forms.multiple-select>
                            @else
                                @if($searchable)
                                    <x-ui::forms.searchable-select id="templateID" name="templateID" class="w-full sm:min-w-40">
                                        {!! $keyValueField->generateOptions($keyValueField->valueOptions, null) !!}
                                    </x-ui::forms.searchable-select>
                                @else
                                    <x-ui::forms.select id="templateID" name="templateID" class="w-full sm:min-w-40">
                                        {!! $keyValueField->generateOptions($keyValueField->valueOptions, null) !!}
                                    </x-ui::forms.select>
                                @endif
                            @endif
                        </div>
                    </div>
                    <x-ui::secondary-button onclick="keyValueRemove(this)">@icon(times)</x-ui::secondary-button>
                </div>
    {{--    </template>--}}
    </script>
    <div id="keyValue-{{$field}}" class="flex flex-col gap-2">
        @if (! empty($value))
            @foreach($value as $v)
                <div id="keyValue-{{$loop->iteration}}" class="keyValueField-{{$field}} w-full flex gap-2 items-center">
                    <div @class(['flex gap-2 items-center flex-wrap grow sm:grow-0', 'sm:!grow' => $fixed]) id="keyValueFields-{{$loop->iteration}}">
                        <div id="key" @class(['basis-full sm:basis-auto', 'grow' => $keyValueField->keyOptions && !$fixed])>
                            @if(! $keyValueField->keyOptions)
                                <x-ui::forms.text-input :id="$field.'['.$loop->iteration.'][key]'" :value="$v->key" :name="$field.'['.$loop->iteration.'][key]'" placeholder='key' :readonly="$fixed" class="w-full" />
                            @else
                                @if($fixed)
                                    <input type="hidden" id='{{$field.'['.$loop->iteration.'][key]'}}' value='{{$v->key}}' name='{{$field.'['.$loop->iteration.'][key]'}}' placeholder='key' class="rounded px-2">
                                    <label>{{$keyValueField->keyOptions[$v->key]}}</label>
                                @else
                                    <x-ui::forms.select :id="$field.'['.$loop->iteration.'][key]'" :name="$field.'['.$loop->iteration.'][key]'" class="w-full sm:min-w-40">
                                        {!! $keyValueField->generateOptions($keyValueField->keyOptions, $v->key) !!}
                                    </x-ui::forms.select>
                                @endif
                            @endif
                        </div>
                        <div id="value" @class(['basis-full sm:basis-auto', 'grow' => $keyValueField->valueOptions])>
                            @if(! $keyValueField->valueOptions)
                                <x-ui::forms.text-input :id="$field.'['.$loop->iteration.'][value]'" :value="$v->value" :name="$field.'['.$loop->iteration.'][value]'" placeholder='value' class="w-full" />
                            @elseif($multiple)
                                <x-ui::forms.multiple-select :id="$field.'['.$loop->iteration.'][value]'" :name="$field.'['.$loop->iteration.'][value][]'" class="w-full sm:min-w-40">
                                    {!! $keyValueField->generateOptions($keyValueField->valueOptions, $v->value) !!}
                                </x-ui::forms.multiple-select>
                            @else
                                @if($searchable)
                                    <x-ui::forms.searchable-select :id="$field.'['.$loop->iteration.'][value]'" :name="$field.'['.$loop->iteration.'][value]'" class="w-full sm:min-w-40">
                                        {!! $keyValueField->generateOptions($keyValueField->valueOptions, $v->value) !!}
                                    </x-ui::forms.searchable-select>
                                @else
                                    <x-ui::forms.select :id="$field.'['.$loop->iteration.'][value]'" :name="$field.'['.$loop->iteration.'][value]'" class="w-full sm:min-w-40">
                                        {!! $keyValueField->generateOptions($keyValueField->valueOptions, $v->value) !!}
                                    </x-ui::forms.select>
                                @endif
                            @endif
                        </div>
                    </div>
                    @if(!$fixed)
                        <x-ui::secondary-button onclick="keyValueRemove(this)">@icon(times)</x-ui::secondary-button>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
    @if(! $fixed)
        <x-ui::secondary-button onclick="keyValueAdd('{{$field}}', '{{$searchable}}', '{{$multiple}}')" class="mt-2"> @icon(plus) {{ __('admin.add') }}</x-ui::secondary-button>
    @endif

    @push('edit-scripts')
        <script>
            function keyValueRemove(element){
                setTimeout(function(){
                    $(element).parent().find('div').detach();
                    $(element).parent().hide();
                }, 100)
            }

            function keyValueAdd(fieldName, searchable, multiple){
                var template    = $("#template-"+fieldName).html();
                var newKeyValue = $(template);
                let n = 100 + Math.floor(Math.random() * 50);

                newKeyValue.prop('id', 'keyValue-' + n);
                newKeyValue.find('#keyValueFields-template').first().prop('id', 'keyValueFields-' + n);

                let key = newKeyValue.find('#key').first();
                let value = newKeyValue.find('#value').first();

                key.find('#templateID').first().prop({'id': fieldName + '['+ n +'][key]', 'name': fieldName + '['+ n +'][key]'});

                if (multiple) {
                    value.find('#templateID').first().prop({'id': fieldName + '['+ n +'][value][]', 'name': fieldName + '['+ n +'][value][]'});
                } else {
                    value.find('#templateID').first().prop({'id': fieldName + '['+ n +'][value]', 'name': fieldName + '['+ n +'][value]'});
                }
                $('#keyValue-' + fieldName).append(newKeyValue);
            }
        </script>
    @endpush
@endcomponent
