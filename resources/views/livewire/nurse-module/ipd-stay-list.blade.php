<div
    x-data = "{
        ward : [],
        rooms : [],
        beds :$wire.beds,
        open :$wire.open,
        ipd:[],
        showActionModal: (row) => {
            selectedId = row.id;
            $dispatch('set-ipd', {ipd : row.ipd});
            $dispatch('initdata',{row: row.ipd});
            acModal.show();
        }
    }"

    x-init = "
        acModal = new Modal($refs.actionModal)
        $wire.loadData()
    "

    @set-staydata.window="(e) => {
        open = true;
        data = e.detail;
        ward = data.ward;
        rooms = data.rooms;
        beds = data.beds;
    }"

    @set-ipd.window="(e) => ipd = e.detail.ipd"
>
    <div x-show="open">
        <div class="flex justify-between">
            <x-header.h5>
                <span x-text="ward.name"></span>
            </x-header.h5>
            <div class="text-right flex gap-1">
                <x-button.icon class="px-3 py-1.5">
                    <i class="fa-solid fa-list text-xl text-neutral-500"></i>
                </x-button.icon>
                <x-button.icon class="px-3 py-1.5">
                    <i class="fa-solid fa-bed-pulse text-xl text-neutral-500"></i>
                </x-button.icon>
            </div>
        </div>
        <div class="grid lg:grid-cols-6 grid-cols-1 gap-4 font-mono text-white text-sm text-center font-bold leading-6 bg-stripes-fuchsia rounded-lg">
            <template x-for="bed in beds">
                <div class="relative">
                    <div
                        x-on:click.prevent="showActionModal(bed)"
                        data-te-ripple-color="light"
                        role="button" class="flex p-4 rounded-lg shadow-lg"
                        :class="(bed.ipd ?? []).length == 0 ? 'bg-gray-600' : (selectedId == bed.id ? 'border-b-4 border-green-800 bg-green-800':'bg-green-600')" >
                        <div x-text="bed.bed_name" class="text-2xl font-bold flex-none"></div>
                        <div class="grow">
                            <div x-text="bed.ipd ? bed.ipd.an : ''" class="w-full text-lg"></div>
                            <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="w-full text-base"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <!--Verically centered modal-->
    <x-tw-modal.dialog
        x-ref="actionModal"
    >
        <x-slot name="title">IPD Actions Menu</x-slot>
        <x-slot name="content">
            <x-nurse.ipd-action />
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary data-te-modal-dismiss>
                Close
            </x-button.secondary>
        </x-slot>
    </x-tw-modal.dialog>
</div>
