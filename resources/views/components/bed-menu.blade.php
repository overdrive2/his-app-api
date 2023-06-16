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
    <div class="grid lg:grid-cols-5 grid-cols-1 gap-2">
        <template x-for="bed in beds">
            <div role="button" @click="value = bed.id" :class="(value === bed.id) ? 'bg-sky-300 dark:bg-sky-600' : ((bed.ipd ?? []).length == 0 ?'bg-gray-200 dark:bg-gray-600' : 'bg-green-200 dark:bg-green-600')"
            class="w-full lg:max-w-sm font-bold border rounded-md shadow-md py-2  dark:text-white">
                <div x-text="bed.ipd ? bed.ipd.an : ''" class="text-xs"></div>
                <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="text-xs"></div>
                <div x-text="bed.bed_name">
                </div>
            </div>
        </template>
    </div>
</div>
