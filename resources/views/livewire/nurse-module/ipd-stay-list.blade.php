<div
    x-data = "{
        ward : [],
        rooms : [],
        errors:{
            bedmove:'',
            wardmove:''
        },
        beds :$wire.beds,
        open :$wire.open,
        ipd:[],
        showActionModal: (row) => {
            selectedId = row.id;
            $dispatch('set-ipd', {ipd : row.ipd});
            $dispatch('initdata',{row: row.ipd});
            acModal.show();
        },
        showMovebedModal: (id) => {
            acModal.hide();
            $wire.moveBedModal(id);
        },
        showMovewardModal: (id) => {
            $wire.moveWardModal(id);
        }
    }"

    x-init = "
        acModal = new Modal($refs.actionModal)
        mbModal = new Modal($refs.mbModal)
        mwModal = new Modal($refs.mwModal) /*Move ward modal*/
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

    @open-mb-modal.window="(e) => { // const listeners movebed modal
        $dispatch('set-beds', {'beds': e.detail.beds})
        mbModal.show()
    }"

    @close-mb-modal.window="() => {
        selectedId = 0
        mbModal.hide()
        $dispatch('toastify');
    }"

    @open-mw-modal.window="(e) => { // const listeners moveward modal
        $dispatch('set-wards', {'wards': e.detail.wards})
        acModal.hide();
        mwModal.show()
    }"

    @close-mw-modal.window="() => {
        mwModal.hide()
        $dispatch('toastify');
    }"

    @bd-err-message.window="(e) => {
        errors = e.detail.errors;
    }"

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
        <button x-on:click="()=> showMovebedModal()">Modal</button>
    </div>
    <!-- Action Menu modal-->
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

    <!-- Bedmove Modal -->
    <x-tw-modal.dialog
        x-ref="mbModal"
        maxWidth="2xl"
        wire:ignore
    >
    <x-slot name="title">Move Bed</x-slot>
    <x-slot name="content">
        <h5 class="text-left text-base font-bold border-b mb-2">{{ __('เลือกเตียง') }}</h5>
        <div class="mb-4">
            <x-bed-menu wire:model.defer="bm.bed_id" />
            <x-error
                x-show="errors.bedmove"
                x-text="errors.bedmove"
            />
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss>
            Close
        </x-button.secondary>
        <x-button.primary wire:click="postBebmove">
            Save
        </x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>

    <!-- Wardmove Modal -->
    <x-tw-modal.dialog
        x-ref="mwModal"
        maxWidth="xl"
    >
    <x-slot name="title">Move Ward</x-slot>
    <x-slot name="content">
        <x-header.h6>
            <span x-text="'AN '+ ipd.an ?? ''"></span>
            <span x-text="ipd.patient_name ?? ''"></span>
        </x-header.h6>
        @livewire('nurse-module.wardmove-entry', ['ipdId' => $ipd_id], key('ipd'.$ipd_id))
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss>
            Close
        </x-button.secondary>
        <x-button.primary @click="$dispatch('save-wardmove')">
            Save
        </x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
