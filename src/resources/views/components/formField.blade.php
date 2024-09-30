@if (isset($inline) && $inline)
    <div style="display:inline-block;">
        {{ $slot }}
    </div>
@else
    <div id="{{$field}}_div"
        class="py-4 w-full"
        x-data="{
            validityMessage: null,
            checkValidity() {
                let invalidInput = $el.querySelector(':invalid');
                if (invalidInput !== null) {
                    this.validityMessage = invalidInput.validationMessage;
                    return;
                }
                this.validityMessage = null;
            }
        }"
        x-on:invalid-form.window="checkValidity">
        <div @class([
            'flex flex-col gap-y-2 gap-x-4',
            'sm:flex-row sm:items-center sm:justify-between' => isset($aside) && $aside
        ])>
            <div @class([
                "field flex flex-col gap-1",
                "w-full" => !(isset($aside) && $aside),
            ])>
                <label class="font-semibold" for="{{$field}}">
                    {{ $title }}
                </label>
                @if (isset($description) && $description)
                    <div class="text-gray-400">{!! $description !!}</div>
                @endif
                @if(isset($learnMoreUrl) && $learnMoreUrl)
                    <x-ui::learn-more href="{{$learnMoreUrl}}" :withIcon="true">
                        {{ __('thrust::messages.learnMore') }}
                    </x-ui::learn-more>
                @endif
            </div>
            <div @class([
                "min-w-36 text-right" => (isset($aside) && $aside)
            ])>
                {{ $slot }}
            </div>
        </div>
        <p x-transition 
            x-cloak 
            x-show="validityMessage" 
            x-text="validityMessage" 
            @class([
                'text-red-500 mt-2',
                'basis-full' => isset($aside) && $aside
            ])>
        </p>
    </div>
@endif