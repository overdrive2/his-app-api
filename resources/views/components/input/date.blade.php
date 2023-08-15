<div
    class="flex items-center justify-center w-full"
    x-data="{
        value: @entangle($attributes->wire('model')),
    }"
    x-init="
        options = window.dateOptions;
        new Datepicker(
            $refs.datepicker,
            options
        );
    "
    wire:ignore
>
    <div
        x-ref="datepicker"
        class='relative mb-3 w-full'
        data-te-input-wrapper-init
        data-te-input-state-active
    >
        <input
            x-ref="input"
            x-bind:value="value"
            value=""
            type="text"
            {{  $attributes->merge(['class'=>'peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-gray-200 dark:placeholder:text-gray-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0']) }}
            placeholder="{{ $label ?? 'Select a date' }}" />
        <label
            for="floatingInput"
            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-gray-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-gray-200 dark:peer-focus:text-gray-200"
        >
            {{ $label ?? 'Select a date' }}
        </label>
    </div>
</div>
