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
>
    <div class="grid lg:grid-cols-1 grid-cols-1 gap-2">
        <template x-for="ward in wards">
            <div role="button" @click="value = ward.id" :class="(value === ward.id) ? 'bg-sky-300 dark:bg-sky-600' : 'bg-gray-200 dark:bg-gray-600'"
            class="w-full lg:max-w-sm font-bold border rounded-md shadow-md py-2  dark:text-white">
                <div x-text="ward.name">
                </div>
            </div>
        </template>
    </div>
</div>
