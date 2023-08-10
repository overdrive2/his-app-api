<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
        new Select($refs.twSelect)
    "
>
    <select
        x-ref="twSelect"
        x-model="model"
        x-bind:value="model"
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
        value=" "
    >
        {{ $slot }}
    </select>
    @if($label)
    <label data-te-select-label-ref class="z-50 bg-white">{{ $label ?? ' ' }}</label>
    @endif
</div>
