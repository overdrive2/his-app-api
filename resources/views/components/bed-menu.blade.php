<div
    x-data="{
        sbeds: [],
        lbeds: beds,
        roomId: null,
        loadFlag: false,
        value: @entangle($attributes->wire('model')),
    }"

    x-init="
    "
    @set-beds.window="(e) => {
        beds = e.detail.beds
        console.log(beds)
       // sbeds = e.detail.beds
       // lbeds = e.detail.beds
       // $dispatch('bedmenu-filter')
    }"

    @bedmenu-filter.window="async ()=> {
        loadFlag = true
        await $wire.bedFilter(checkShowBedEmpty);
        loadFlag = false
        //lbeds = checkShowBedEmpty ? lbeds.filter(bed => (bed.ipd && bed.ipd.length == 0)||(!bed.ipd)) : sbeds
    }"
>
    <div class="relative flex gap-2 flex-col">
        <div x-show="loadFlag" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <x-spinner /> <div class="mt-2 text-base font-medium dark:text-gray-100">Loading...</div>
        </div>
        <template x-for="bed in beds">
            <button
                x-bind:class="loadFlag ? 'opacity-25' : ''"
                type="button"
                x-bind:disabled="!bed.empty_flag"
                x-on:click="() => {
                    value = bed.id
                    bedEditing.to = bed.bed_name
                }"
                :class="(value === bed.id) ? 'bg-teal-400 dark:bg-teal-600' : (bed.empty_flag ? 'bg-primary-100 dark:bg-primary-600' : 'bg-gray-200 dark:bg-gray-600')"
                class="flex w-full gap-2 border rounded-md shadow-md py-2  dark:text-white"
            >
                <div class="px-2 flex-none w-24 font-bold" x-text="bed.bed_name"></div>
                <template x-if="bed.empty_flag == false">
                    <div class="flex gap-2">
                        <div x-text="bed.ipd ? bed.ipd.an : ''" class="px-2 flex-none w-auto"></div>
                        <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="text-left px-2 grow"></div>
                    </div>
                </template>
            </button>
        </template>
    </div>
</div>
