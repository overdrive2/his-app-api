<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
>
    <select
        x-model="model"
        data-te-select-init
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
    >
        {{ $slot }}
    </select>
    @if($label)
    <label data-te-select-label-ref class="z-50 bg-white">{{ $label ?? '' }}</label>
    @endif
</div>
