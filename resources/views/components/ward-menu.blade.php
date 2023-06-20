<div
    x-data="{
        wards: [],
        wardId: null,
        value: @entangle($attributes->wire('model')),
        open: false
    }"

    @set-wards.window="(e) => {
        wards = e.detail.wards
        open = true
    }"
    style="display: none;"
    x-show="open"
    class='w-full'
    wire:ignore
>
    <div class="flex flex-col gap2">
        <template x-for="item in wards">
            <div x-show="item.id != ward.id"
                role="button"
                class="border-b py-2 hover:bg-sky-200 dark:hover:bg-gray-200 border-gray-500 dark:border-gray-200"
                @click="value = item.id" :class="(value === item.id) ? 'bg-sky-200 dark:bg-sky-600' : 'border-gray-500 dark:border-gray-200'"
                class="w-full font-bold py-2 dark:text-white">
                <div x-text="item.name">
                </div>
            </div>
        </template>
    </div>
</div>
