<div
    x-data="{
        sbeds: [],
        lbeds: [],
        roomId: null,
        value: @entangle($attributes->wire('model')),
    }"

    @set-beds.window="(e) => {
        sbeds = e.detail.beds
        lbeds = e.detail.beds
        $dispatch('bedmenu-filter')
    }"

    @bedmenu-filter.window="()=> {
        lbeds = checkShowBedEmpty ? lbeds.filter(bed => (bed.ipd && bed.ipd.length == 0)||(!bed.ipd)) : sbeds
    }"
>
    <div class="flex gap-2 flex-col">
        <template x-for="bed in lbeds">
            <button
                type="button"
                x-bind:disabled="!((bed.ipd && bed.ipd.length == 0)||(!bed.ipd))"
                x-on:click="() => {
                    console.log(bed)
                    value = bed.id
                    ds_bed = bed.bed_name
                }"
                :class="(value === bed.id) ? 'bg-teal-400 dark:bg-teal-600' : ((bed.ipd ?? []).length == 0 ? 'bg-primary-100 dark:bg-primary-600' : 'bg-gray-200 dark:bg-gray-600')"
                class="flex w-full gap-2 border rounded-md shadow-md py-2  dark:text-white"
            >
                <div class="px-2 flex-none w-24 font-bold" x-text="bed.bed_name"></div>
                <div x-text="bed.ipd ? bed.ipd.an : ''" class="px-2 flex-none w-auto"></div>
                <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="text-left px-2 grow"></div>
            </button>
        </template>
    </div>
</div>
