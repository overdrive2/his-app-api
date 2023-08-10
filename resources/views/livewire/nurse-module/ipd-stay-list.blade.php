<div
    x-data="{
        errors: [],
        ward: @js($ward),
        beds: @js($beds),
        ipd: [],
        room_id: @entangle('room_id'),
        rooms: @js($rooms),
        filter_room_id: @entangle('filter_room_id'),
        rbeds: [],
        srcTxt: '',
        showActionModal: (row) => {
            $dispatch('set-ipd', { row: row });
            $dispatch('initdata', { row: row.ipd });
            acModal.show();
        },
        showMovebedModal: async (id) => {
            $dispatch('cat:progress')
            await $wire.moveBedModal(id);
            $dispatch('swal:close')
        },
        bedFilter:(val) => {
            $wire.set('search', val)
        },
        save: () => {
            $wire.postBedmove()
        }
    }"
    x-init="
        rbeds = {...beds}
        acModal = new Modal($refs.actionModal)
        mbModal = new Modal($refs.mbModal)
    "

    @showaction-modal.window="(e) => {
        $dispatch('set-ipd', { row: e.detail.row });
        $dispatch('initdata', { row: e.detail.row.ipd  })
        acModal.show();
    }"

    @set-rbeds-filter="(e)=>{
        beds = e.detail.beds
        rbeds = {...beds}
    }"

    @set-staydata.window="(e)=>{
        beds = {...e.detail.beds}
        rbeds = {...beds}
    }"

    @bed-filter="()=> {
        rbeds = srcTxt != '' ? beds.filter(bed => bed.ipd && bed.ipd.patient_name.includes(srcTxt) == true) : beds
    }"

    @open-mb-modal.window="(e) => { // const listeners movebed modal
        rooms = e.detail.rooms
        $dispatch('set-beds', {'beds': e.detail.beds})
        acModal.hide()
        mbModal.show()
    }"

    @close-mb-modal.window="(e) => {
        beds = {...e.detail.beds}
        rbeds = {...beds}
        mbModal.hide()
      //  $dispatch('swal:close')
        $dispatch('toastify');
    }"

    @set-ipd.window="(e) => {
        ipd = e.detail.row.ipd
        ipd.bed_name = e.detail.row.bed_name
    }"

    @err-message.window = "(e) => {
        errors = JSON.parse(e.detail.errors);
        console.log(errors)
    }"
>
    <div class="flex justify-between">
        <x-header.h5 class="ml-1 mb-1">
            <span x-text="ward.name"></span>
        </x-header.h5>
        <div class="text-right flex gap-1">
        </div>
    </div>
    <div class="max-w-full overflow-x-auto">
        <div class="mb-3">
            <div class="flex justify-between">
                <div class="lg:w-1/2 flex flex-none w-full gap-2">
                    <div x-init="new Select($refs.roomFilterSelect)" class="flex-none w-auto py-1.5" wire:ignore>
                        <select x-ref="roomFilterSelect" x-model="filter_room_id">
                            <option value="0">-- ทุกห้อง --</option>
                            <template x-for="item in rooms">
                                <option :selected="item.id == filter_room_id" :value='item.id'
                                    x-text='item.room_name'></option>
                            </template>
                        </select>
                    </div>
                    <div class="relative py-1.5 grow flex max-w-xs w-full flex-wrap items-stretch">
                        <input x-model="srcTxt" x-on:change="bedFilter(srcTxt)" type="search"
                            class="relative m-0 block w-[1px] min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                            placeholder="Search" aria-label="Search" aria-describedby="button-search" />
                        <button
                            type="button"
                            x-on:click="$wire.emit('beds:refresh')"
                            class="text-lg font-normal text-gray-600 dark:text-gray-200 input-group-text flex items-center whitespace-nowrap rounded px-3 py-1.5 text-center"
                        >
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                </div>
                <div class="lg:w-1/2 lg:flex grow w-auto justify-end">
                    <x-button.icon class="px-3 py-1.5" @click="$store.ipdViewMode.toggle()">
                        <i :class="$store.ipdViewMode.value == 'flex' ? 'text-primary-600 fa-solid fa-list' :
                            'text-neutral-500 fa-solid fa-table-cells'"
                            class=" text-xl"></i>
                    </x-button.icon>
                </div>
            </div>
        </div>
        <div class="gap-2" :class="$store.ipdViewMode.value == 'flex' ? 'flex flex-col' : 'grid grid-cols-4'">
            <template x-for="row in rbeds" :key="row.id">
                <div class="flex px-4 py-2 border rounded">
                    <div class="grow flex gap-2">
                        <div class="p-2 flex-none w-32 font-medium" x-text="row.bed_name"></div>
                        <div class="p-2" x-text="row.ipd && row.ipd.patient_name">
                        </div>
                    </div>
                    <div class="flex-none w-14 flex flex-col">
                        <button x-on:click.prevent="showActionModal(row)" type="button">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <!-- Action Menu modal-->
    <x-tw-modal.dialog x-ref="actionModal">
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
    <x-tw-modal.dialog maxWidth="2xl" wire:ignore>
        <x-slot name="title">Move Bed</x-slot>
        <x-slot name="content">
            <div class="mb-2" x-data x-init="new Select($refs.roomSelect)">
                <h5 class="text-left text-base font-bold border-b mb-2">เลือกห้อง</h5>
                <select x-ref="roomSelect" x-model="room_id">
                    <option value="0">-- ทั้งหมด --</option>
                    <template x-for="item in rooms">
                        <option :selected="item.id == room_id" :value='item.id' x-text='item.room_name'></option>
                    </template>
                </select>
            </div>
            <h5 class="text-left text-base font-bold border-b mb-2">เลือกเตียง</h5>
            <div class="mb-4">
                <x-bed-menu wire:model.defer="bm.bed_id" />
                <x-error x-show="errors.bedmove" x-text="errors.bedmove" />
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

    <!-- Bedmove Modal -->
    <x-tw-modal.dialog maxWidth="2xl" wire:ignore>
        <x-slot name="title">Move Bed</x-slot>
        <x-slot name="content">
            <div class="mb-2" x-data x-init="new Select($refs.roomSelect)">
                <h5 class="text-left text-base font-bold border-b mb-2">เลือกห้อง</h5>
                <select x-ref="roomSelect" x-model="room_id">
                    <option value="0">-- ทั้งหมด --</option>
                    <template x-for="item in rooms">
                        <option :selected="item.id == room_id" :value='item.id' x-text='item.room_name'></option>
                    </template>
                </select>
            </div>
            <h5 class="text-left text-base font-bold border-b mb-2">เลือกเตียง</h5>
            <div class="mb-4">
                <x-bed-menu wire:model.defer="bm.bed_id" />
                <x-error x-show="errors.bedmove" x-text="errors.bedmove" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary data-te-modal-dismiss>
                Close
            </x-button.secondary>
            <x-button.primary
                x-on:click="()=> {
                    $dispatch('cat:progress')
                    $wire.postBebmove()
                }"
            >
                Save
            </x-button.primary>
        </x-slot>
    </x-tw-modal.dialog>

    <div
        x-ref="mbModal"
        data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="mbModal" tabindex="-1" aria-labelledby="MoveInLabel" aria-hidden="true"
        wire:ignore
    >
        <div data-te-modal-dialog-ref
            class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                x-data="{
                    ds_bed:'-',
                    checkShowBedEmpty: true
                }"
                class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600"
            >
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50"
                >
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                        id="MoveInLabel">
                        ย้ายภายใน Ward
                    </h5>
                    <!--Close button-->
                    <x-button.icon data-te-modal-dismiss aria-label="Close">
                        <x-icon.close />
                    </x-button.icon>
                </div>
                <div class="p-4">
                    <div class="flex mb-2 font-bold text-base justify-center py-1 border-b">
                        <div x-text="'AN ' + ipd.an" class="px-2 w-auto"></div>
                        <div x-text="'ชื่อ-สกุล '+ ipd.patient_name" class="text-left px-2 w-auto"></div>
                    </div>
                    <div class="flex gap-4 mb-2">
                        <div class="grow">
                            <div class="font-bold text-primary">เตียงปัจจุบัน</div>
                            <div class="bg-primary-100 text-center w-full gap-2 border rounded-md shadow-md py-2  dark:text-white">
                                <div class="px-2 font-bold" x-text="ipd.bed_name"></div>
                            </div>
                        </div>
                        <div class="flex-none w-auto">
                            <div class="mt-8">
                                <i class="text-primary fa-solid fa-circle-right"
                                ></i>
                            </div>
                        </div>
                        <div class="grow">
                            <div class="font-bold text-teal-700">เตียงปลายทาง</div>
                            <div class="bg-teal-100 text-center w-full gap-2 border rounded-md shadow-md py-2  dark:text-white">
                                <div class="px-2 font-bold" x-text="ds_bed"></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <x-input.date wire:model.defer="bedmove.date_for_editing" />
                        <x-input.tw-time
                            id="time_edit"
                            wire:model.defer="bedmove.time_for_editing"
                        />
                    </div>
                </div>
                <!--Modal body-->
                <div class="relative overflow-y-auto p-4">
                    <x-bed-menu wire:model.defer="bedmove.bed_id" />
                </div>
                <!--Modal footer-->
                <x-tw-modal.footer>
                    <div class="flex-none px-2 text-left">
                        <input x-on:change="$dispatch('bedmenu-filter')" x-model="checkShowBedEmpty" id="checkShowBedEmpty" type="checkbox" class="h-4 w-4">
                        <label for="checkShowBedEmpty" class="inline-block mb-1">แสดงเฉพาะเตียงว่าง</label>
                    </div>
                    <div class="grow text-right">
                        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
                        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
                    </div>
                </x-tw-modal.footer>
            </div>
        </div>
    </div>
</div>
