<label
    {{  $attributes->merge([
        'class' => 'px-1 bg-white dark:dark:bg-zinc-800 pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:scale-[0.8] peer-focus:text-primary -translate-y-[1.00rem] scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary'])
    }}
>
    {{ $slot }}
</label>
