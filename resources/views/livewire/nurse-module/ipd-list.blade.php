<div
    x-data="{
        wards:@js($wards),
        rooms:@js($rooms),
        moveType:'',
        ward_id:@entangle('ward_id'),
        room_id:@entangle('room_id'),
        showActionModal: async (id) => {
            $dispatch('cat:progress')
            await $wire.edit(id)
            acModal.show()
            $dispatch('swal:close')
        },
    }"
    x-init="
       acModal = new Modal($refs.actionModal)
       bmModal = new Modal($refs.bmModal)
    "
    @set-rooms.window="(e)=>{ rooms = e.detail.rooms }"

>
    <div class="flex gap-2">
        <div  class="flex-none w-full max-w-xs py-1.5" wire:ignore>
            <select x-ref="wardFilterSelect" x-model="ward_id" data-te-select-init>
                <option value="0">-- เลือกหอผู้ป่วย --</option>
                <template x-for="ward in wards">
                    <option :selected="ward.id == ward_id" :value='ward.id'
                        x-text='ward.name'></option>
                </template>
            </select>
            <label data-te-select-label-ref >หอผู้ป่วย</label>
        </div>
        <div  class="flex-none w-full max-w-xs py-1.5" wire:ignore>
            <select x-bind:disabled="ward_id == 0" x-ref="wardFilterSelect" x-model="room_id" data-te-select-init>
                <option value="0">-- ทั้งหมด --</option>
                <template x-for="room in rooms">
                    <option :selected="room.id == room_id" :value='room.id'
                        x-text='room.room_name'></option>
                </template>
            </select>
            <label data-te-select-label-ref >ห้อง</label>
        </div>
        <div class="lg:w-1/2 lg:flex grow w-auto justify-end">
            <x-button.icon class="px-3 py-1.5" @click="$store.ipdViewMode.toggle()">
                <i :class="$store.ipdViewMode.value == 'flex' ? 'text-primary-600 fa-solid fa-list' :
                    'text-neutral-500 fa-solid fa-table-cells'"
                    class=" text-xl"></i>
            </x-button.icon>
        </div>
    </div>
    <div class="gap-2" :class="$store.ipdViewMode.value == 'flex' ? 'flex flex-col' : 'grid grid-cols-4'">
        @foreach($rows as  $row)
            <div class="flex px-4 py-2 border rounded">
                <div class="grow flex gap-2">
                    <div class="p-2 flex-none w-32 font-medium">{{ $row->bed_name }}</div>
                    <div class="p-2">
                        {{ $row->ipd->patient_name ?? '' }}
                    </div>
                </div>
                <div class="flex-none w-14 flex flex-col">
                    <button x-on:click.prevent="showActionModal('{{ $row->id }}')" type="button">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                </div>
            </div>
        @endforeach
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

    <x-tw-modal.dialog x-ref="bmModal" maxWidth="2xl">
        <x-slot name="title"><h4 x-text="moveType"></h4></x-slot>
        <x-slot name="content">
            <x-input.tw-text label="Type" wire:model.defer="editing.bedmove_type_id" />
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary data-te-modal-dismiss>
                Close
            </x-button.secondary>
        </x-slot>
    </x-tw-modal.dialog>

</div>
