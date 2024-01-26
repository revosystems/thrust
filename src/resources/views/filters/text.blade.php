<x-ui::forms.text-input class="w-full"
    name="{{ $filter->class() }}"
    title="{{$filter->getTitle()}}"
    value="{{$value}}"
    placeholder="{{$filter->getTitle()}}"
/>