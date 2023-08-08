<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="
        sl = Select.getInstance($refs.twSelect)
        sl.setValue('183')
    "
>
    <select
        data-te-select-init
        x-ref="twSelect"
        x-model="model"
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
    >
        {{ $slot }}
    </select>
    @if($label)
    <label data-te-select-label-ref class="z-50 bg-white">{{ $label ?? ' ' }}</label>
    @endif
</div>
