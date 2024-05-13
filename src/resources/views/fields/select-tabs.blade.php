<x-thrust::formField :field="$field" :title="$title" :description="$description" :aside="$showAside" :inline="$inline" :learnMoreUrl="$learnMoreUrl">
    <div class="min-w-sm">
        <x-ui::forms.tabs-select id={{$field}} name={{$field}} :options="$options" :selected="$value"/>
    </div>
</x-thrust::formField>