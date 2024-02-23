<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <x-ui::forms.select-tabs id={{$field}} name={{$field}} :options="$options" :selected="$value"/>
</x-thrust::formField>