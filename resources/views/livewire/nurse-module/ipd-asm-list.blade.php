<div
    x-data="{
        errors:[],
        nrsShifs:@js($nurse_shifs),
        newAsm:()=>{
            $dispatch('cat:progress');
            $wire.new()
        },
        save: () => {
            $dispatch('cat:progress');
            $wire.save()
        }
    }"
    x-init="
        edModal = new Modal($refs.edModal)
    "
    @asm-modal-show.window = "(e) => {
        setTimeout(() => {
            $dispatch('swal:close')
            edModal.show()
        }, 1000);
    }"

    @asm-modal-hide.window = "() => {
        edModal.hide()
    }"

    @err-message.window = "(e) => {
        setTimeout(() => {
            errors = JSON.parse(e.detail.errors);
            $dispatch('swal:close')
        }, 1000)
    }"
>
    <div class="mb-4">
        <div>AN {{ $ipd->an }} HN {{ $ipd->hn }}</div>
        <div>ชื่อ - สกุล {{ $ipd->patient_name }}</div>
    </div>
    <h4>ASM List</h4>
    <div class="flex justify-between">
        <div></div>
        <div class="text-right">
            <x-button.primary type="button" x-on:click="() => { newAsm() }">New</x-button.primary>
        </div>
    </div>
    <x-table>
        <x-slot name="header">
            <tr>
                <th scope="col" class="px-2">Id</th>
                <th scope="col" class="px-2">Type</th>
                <th scope="col" class="px-2">Date</th>
                <th scope="col" class="px-2">Time</th>
                <th scope="col" class="px-2">By</th>
                <th scope="col" class="px-2">Action</th>
            </tr>
        </x-slot>
        <x-slot name="content">
        @foreach($rows as $key => $row)
            <x-table.row
                role="button"
                :key="$key"
                id="row{{$row->id}}"
                x-on:click="()=>{ location.assign('{{ route('nurse.asm.entry') }}?id={{ $row->id }}') }"
            >
                <x-table.cell>{{ $row->id }}</x-table.cell>
                <x-table.cell>{{ $row->type_name ?? '' }}</x-table.cell>
                <x-table.cell>{{ $row->asm_date }}</x-table.cell>
                <x-table.cell>{{ $row->asm_time }}</x-table.cell>
                <x-table.cell>{{ $row->create_by_name }}</x-table.cell>
                <x-table.cell>
                    <button type="button">แก้ไข</button>
                    <button type="button" wire:click="delete('{{ $row->id }}')">ลบ</button>
                </x-table.cell>
            </x-table.row>
        @endforeach
        </x-slot>
    </x-table>

    <x-tw-modal.dialog
        x-ref="edModal"
        maxWidth="2xl"
        wire:ignore
    >
    <x-slot name="title">รับเข้าเตียง</x-slot>
    <x-slot name="content">
        <div class="grid grid-cols-2 gap-4">
            <x-input.date wire:model="editing.date_for_editing" />
            <x-input.tw-time
                id="time_edit"
                wire:model="editing.time_for_editing"
            />
        </div>
        <div class="mb-2 text-left">เวร</div>
        <x-input.select :label="null" wire:model="editing.ipd_nurse_shift_id">
            <option value="0">-- เลือกเวร --</option>
            <template x-for="item in nrsShifs">
                <option :value='item.id' x-text='item.nurse_shift_name'></option>
            </template>
        </x-input.select>
        <x-error
            x-show="errors['editing.ipd_nurse_shift_id']"
            x-text="errors['editing.ipd_nurse_shift_id']"
        />
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary x-on:click="() => edModal.hide()">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
