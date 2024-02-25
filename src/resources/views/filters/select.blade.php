<x-ui::forms.searchable-select class="w-full min-w-60" name="{{ $filter->class() }}" title="{{$filter->getTitle()}}">
    <option value="--">--</option>
    @foreach ($filter->options() as $key => $optionValue)
        <option value="{{$optionValue}}" @if($value != null && $value != '--' && $value == $optionValue) selected @endif>{{$key}} </option>
    @endforeach
</x-ui::forms.searchable-select>
