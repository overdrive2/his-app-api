<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
>
    <select data-te-select-init
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
    >
        {{ $slot }}
    </select>
    <label class="z-50 bg-white" data-te-select-label-ref>{{ $label ?? '' }}</label>
</div>
