<div
    x-data="{
        wards: @js($user->wards()),
        rooms: [],
        beds: [],
        ipd: {
            an:'',
            hn:'',
            patient_name:'',
        },
        edit: (id) => {
            $dispatch('cat:progress');
            $wire.edit(id);
        }
    }"

    @bded-modal-show.window="(e) => {
        ipd = e.detail.ipd
        setTimeout(() => {
            bdedModal.show()
            $dispatch('swal:close')
        }, 1000)
    }"

    x-init="
        bdedModal = new Modal($refs.bdedModal);
        clearError = () => {
            errors = [];
        }
    "
>
    <x-table>
        <x-slot name="header">
            <tr>
                <th scope="col" class="px-6 py-4 text-center">รหัส</th>
                <th scope="col" class="px-6 py-4">วันที่</th>
                <th scope="col" class="px-6 py-4">เวลา</th>
                <th scope="col" class="px-6 py-4">หอผู้ป่วย</th>
                <th scope="col" class="px-6 py-4">ห้อง</th>
                <th scope="col" class="px-6 py-4">เตียง</th>
                <th scope="col" class="px-6 py-4">สถานะ</th>
                <th scope="col" class="px-6 py-4">เตียง</th>
                <th scope="col" class="px-6 py-4">ผู้บันทึก</th>
                <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th>
            </tr>
        </x-slot>
        <x-slot name="content">
        @foreach($rows as $key => $row)
        <x-table.row :key="$key">
            <x-table.cell class="text-center">{{ $row->id }}</x-table.cell>
            <x-table.cell>{{ $row->date_for_thai }}</x-table.cell>
            <x-table.cell>{{ $row->time_for_editing }} น.</x-table.cell>
            <x-table.cell>{{ $row->ward_name }}</x-table.cell>
            <x-table.cell>{{ $row->room_name }}</x-table.cell>
            <x-table.cell>{{ $row->movetype_name }}</x-table.cell>
            <x-table.cell>{{ $row->room_id }}</x-table.cell>
            <x-table.cell></x-table.cell>
            <x-table.cell></x-table.cell>
            <x-table.cell>
                <div class="flex justify-center gap-2">
                    <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                        <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                    </x-button.secondary>
                    <x-button.secondary wire:click="deleteConfirm('{{ $row->id }}')">
                        <x-icon.trash class="w-4 h-4" /> ลบ
                    </x-button.secondary>
                </div>
            </x-table.cell>
        </x-table.row>
        @endforeach
        </x-slot>
    </x-table>

    <!-- Edit Modal -->
    <x-tw-modal.dialog
        x-ref="bdedModal"
        maxWidth="xl"
        wire:ignore
    >
    <x-slot name="title">แก้ไขการครองเตียงราย AN</x-slot>
    <x-slot name="content">
        <x-card.ipd-mini />
        <!--Ward input-->
        <div class="mb-6" >
            <x-input.select :label="__('หอผู้ป่วย')" wire:model="editing.ward_id">
                <option value="0">-- เลือกหอผู้ป่วย --</option>
                <template x-for="ward in wards">
                    <option :value='ward.id' x-text='ward.name'>
                    </option>
                </template>
            </x-input.select>
        </div>

        <div class="mb-6" @rooms-update.window="(e) => { rooms = e.detail.rooms }">
            {{ $editing->room_id ?? '' }}
            <x-input.select :label="__('ห้อง')" wire:model="editing.room_id">
                <option value="0">-- เลือกห้อง --</option>
                <template x-for="room in rooms">
                    <option :value='room.id' x-text='room.room_name'>
                    </option>
                </template>
            </x-input.select>
        </div>

        <div
            class="mb-6 text-left"
            @beds-update.window="(e) => {
                beds = e.detail.beds
            }"
        >
            <x-input.select :label="__('เตียง')" wire:model="editing.bed_id">
                <option value="0">-- เลือกเตียง --</option>
                <template x-for="bed in beds">
                    <option :value='bed.id' x-text='bed.bed_name'>
                    </option>
                </template>
            </x-input.select>
            <x-error x-show="errors['editing.bed_id']"
                x-text="errors['editing.bed_id']"
            ></x-error>
        </div>

    </x-slot>
    <x-slot name="footer">
        <x-button.secondary>ยกเลิก</x-button.secondary>
        <x-button.primary>บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
    <!-- End Modal -->
</div>
