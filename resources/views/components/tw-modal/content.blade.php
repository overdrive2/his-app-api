@props(['scrollable' => false])

<div {{ $attributes->merge(['class'=> $scrollable ?
    'pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600'
    :'pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600']) }}
>
    {{ $slot }}
</div>
