<div
    x-data="{
        beds: [],
        roomId: null,
        value: @entangle($attributes->wire('model')),
        open: false
    }"

    @set-beds.window="(e) => {
        beds = e.detail.beds
        open = true
    }"
    style="display: none;"
    x-show="open"
>
    <div class="flex gap-2 flex-col">
        <template x-for="bed in beds">
            <button
                type="button"
                x-bind:disabled="bed.ipd.length != 0"
                x-on:click="() => {
                    value = bed.id
                    ds_bed = bed.bed_name
                }"
                :class="(value === bed.id) ? 'bg-primary-400 dark:bg-primary-600' : ((bed.ipd ?? []).length == 0 ? 'bg-primary-100 dark:bg-primary-600' : 'bg-gray-200 dark:bg-gray-600')"
                class="flex w-full gap-2 border rounded-md shadow-md py-2  dark:text-white"
            >
                <div class="px-2 flex-none w-24 font-bold" x-text="bed.bed_name"></div>
                <div x-text="bed.ipd ? bed.ipd.an : ''" class="px-2 flex-none w-auto"></div>
                <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="text-left px-2 grow"></div>
            </button>
        </template>
    </div>
</div>
