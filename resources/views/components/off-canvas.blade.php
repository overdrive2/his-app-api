<div
    wire:ignore
>
    <div
        {{ $attributes->merge(['class'=>'invisible fixed bottom-0 right-0 top-0 z-[1045] flex w-96 max-w-full translate-x-full flex-col border-none bg-white bg-clip-padding text-neutral-700 shadow-sm outline-none transition duration-300 ease-in-out dark:bg-neutral-800 dark:text-neutral-200 [&[data-te-offcanvas-show]]:transform-none'])}}
        tabindex="-1"
        data-te-offcanvas-init
    >
        <div class="flex items-center justify-between p-4">
            <h5
                class="mb-0 font-semibold leading-normal"
                x-text="'เตียง ' + $store.bed.data.name"
            >

            </h5>
            <x-button.icon data-te-offcanvas-dismiss aria-label="Close">
                <x-icon.close />
            </x-button.icon>
        </div>
        <div class="flex-grow overflow-y-auto p-4">
            <div>
            {{ $slot }}
            </div>
        </div>
    </div>
</div>
