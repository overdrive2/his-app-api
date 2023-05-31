<div
    x-data = "{
        moveout: {{ config('ipd.moveout') }},
        ward_id: @entangle('ward_id'),
        type_id: @entangle('editing.bedmove_type_id'),
        ipd: @entangle('ipd'),
        moveout: null,
        wards: [],
        rooms: [],
        beds: [],
        errors: [],
        modalShow: (id) => {
            clearError()
            $wire.editMove(id)
        }
    }"
    x-init = "
        modal = new Modal($refs.modal);
        clearError = () => {
            errors = [];
        }
    "
>
    <x-table>
        <x-slot name="header">
            <tr>
                <th scope="col" class="px-6 py-4">ลำดับ</th>
                <th scope="col" class="px-6 py-4">วันที่</th>
                <th scope="col" class="px-6 py-4">เวลา</th>
                <th scope="col" class="px-6 py-4">สถานะ</th>
                <th scope="col" class="px-6 py-4">หอผู้ป่วย</th>
                <th scope="col" class="px-6 py-4">หอผู้ป่วย</th>
                <th scope="col" class="px-6 py-4">เตียง</th>
                <th scope="col" class="px-6 py-4">ผู้บันทึก</th>
                <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th>
            </tr>
        </x-slot>
        <x-slot name="row">
        @foreach($rows as $key => $row)
        <x-table.row :key="$key">
            <x-table.cell class="text-center">{{ $key+1 }}</x-table.cell>
            <x-table.cell>{{ $row->date_for_thai }}</x-table.cell>
            <x-table.cell>{{ $row->time_for_editing }} น.</x-table.cell>
            <x-table.cell>{{ $row->movetype_name }}</x-table.cell>
            <x-table.cell>{{ $row->room_id }}</x-table.cell>
            <x-table.cell></x-table.cell>
            <x-table.cell></x-table.cell>
            <x-table.cell></x-table.cell>
            <x-table.cell>
                <div class="flex justify-center gap-2">
                    <x-button.edit style="background-color: #f48024" x-on:click="modalShow('{{ $row->id }}')">
                    </x-button.edit>
                    <x-button.delete wire:click="deleteConfirm('{{ $row->id }}')" style="background-color: #ea4c89">
                    </x-button.delete>
                </div>
            </x-table.cell>
        </x-table.row>
        @endforeach
        </x-slot>
    </x-table>

    <!-- Edit Modal -->
    <x-nurse.ipd-bedmove-modal />
    <!-- End Modal -->
</div>
