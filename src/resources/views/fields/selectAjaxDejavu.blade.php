<x-thrust::formField :field="$field" :title="$title" :description="$description"  :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <x-ui::forms.ajax-searchable-select
            name="{{$field}}"
            id="{{$field}}"
            :icon="$icon ?? null"
            :allowNull="$allowNull"
            :url="route('thrust.relationship.search', [$resourceName, $id ?? 0, $relationship])"
            :selected="['id' => $value, 'name' => $name]"
    />
</x-thrust::formField>