{{--
    https://www.webdew.com/blog/google-places-autocomplete-implementation
--}}
<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline">

    <style>
        .pac-container {
            z-index: 1000000 !important;
        }
    </style>

    <div class="places">
        <x-ui::forms.text-input icon="location-dot" type="text" name="{{$field}}" id="{{$field}}" placeholder="{{$title}}" value="{{$value}}"  {{ $attributes->merge(['class' => 'w-full']) }}  autocomplete="off"/>
    </div>

    @push('edit-scripts')
    <script>
        function gmFindAddressComponent(place, type, format = 'long_name') {
            const address = place.address_components.find(o => o.types.indexOf(type) !== -1);
            return address ? address[format] : '';
        }
        const gmAutocomplete = new google.maps.places.Autocomplete(document.getElementById('{{$field}}'));

        gmAutocomplete.addListener('place_changed', () => {
            const place = gmAutocomplete.getPlace();
            const street = gmFindAddressComponent(place, 'route') || gmFindAddressComponent(place, 'premise');
            const number = gmFindAddressComponent(place, 'street_number');
            document.getElementById('{{$field}}').value = number ? `${street}, ${number}` : street;
            @if($relatedFields['city'])
                document.getElementById('{{$relatedFields['city']}}').value = gmFindAddressComponent(place, 'locality');
            @endif
            @if($relatedFields['postalCode'])
                document.getElementById('{{$relatedFields['postalCode']}}').value = gmFindAddressComponent(place, 'postal_code');
            @endif
            @if($relatedFields['state'])
                document.getElementById('{{$relatedFields['state']}}').value = gmFindAddressComponent(place, 'administrative_area_level_2');
            @endif
            @if($relatedFields['country'])
                document.getElementById('{{$relatedFields['country']}}').value = gmFindAddressComponent(place, 'country', 'short_name');
                document.dispatchEvent(new CustomEvent('places-updated', {
                    detail: {
                        shortName: gmFindAddressComponent(place, 'country', 'short_name'),
                        longName: gmFindAddressComponent(place, 'country')
                    }
                }));
            @endif
        });
    </script>
    @endpush
</x-thrust::formField>
