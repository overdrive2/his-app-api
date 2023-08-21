@props([
    'id',
    'label' => '',
])
<div wire:ignore>
    <div
        {{ $attributes->merge(['class'=>'invisible fixed bottom-0 right-0 top-0 z-[1045] flex w-96 max-w-full translate-x-full flex-col border-none bg-white bg-clip-padding text-neutral-700 shadow-sm outline-none transition duration-300 ease-in-out dark:bg-neutral-800 dark:text-neutral-200 [&[data-te-offcanvas-show]]:transform-none'])}}
        tabindex="-1"
        data-te-offcanvas-init
    >
        <div class="flex items-center justify-between p-4">
            <h5
            class="mb-0 font-semibold leading-normal"
            >
            {{ $label }}
            </h5>
            <button
                type="button"
                class="box-content rounded-none border-none opacity-50 hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                data-te-offcanvas-dismiss
            >
                <span
                    class="w-[1em] focus:opacity-100 disabled:pointer-events-none disabled:select-none disabled:opacity-25 [&.disabled]:pointer-events-none [&.disabled]:select-none [&.disabled]:opacity-25">
                    <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-6 w-6">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>
        </div>
        <div class="flex-grow overflow-y-auto p-4">
            <div>
            {{ $slot }}
            </div>
        </div>
    </div>
</div>
