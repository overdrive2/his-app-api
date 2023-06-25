@props(['maxWidth'])

@php

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
][$maxWidth ?? 'md'];
@endphp

<div
    data-te-modal-init
    {{ $attributes->merge(['class'=>'fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none']) }}
    tabindex="-1"
    aria-modal="true"
    role="dialog"
>
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] {{$maxWidth}}"
    >
        <x-tw-modal.content>
            <x-tw-modal.header>
                <!--Modal title-->
                <x-header.h5>
                    {{ $title }}
                </x-header.h5>
                <!--Close button-->

                <x-button.icon data-te-modal-dismiss aria-label="Close">
                    <x-icon.close />
                </x-button.icon>
            </x-tw-modal.header>

            <!--Modal body-->
            <div class="p-4">
                {{ $content }}
            </div>
            <!--Modal footer-->
            <x-tw-modal.footer>
                {{ $footer }}
            </x-tw-modal.footer>
        </x-tw-modal.content>
    </div>
</div>
