<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
>
    <select
        x-bind:value="model"
        data-te-select-init
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
    >
        {{ $slot }}
    </select>
    <label data-te-select-label-ref class="z-20 bg-white dark:bg-opacity-0">{{ $label ?? '' }}</label>
</div>
