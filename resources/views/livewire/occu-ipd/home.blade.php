<div 
    x-data="{
        errors:[],
        nurseshifts: @js($nurseshifts),
        save: () => {
            $dispatch('cat:progress');
            $wire.save();
        },
        edit: (id) => {
            $dispatch('cat:progress');
            $wire.edit(id);
        }
    }" 
    
    x-init="ipdmainModal = new Modal($refs.ipdmainModal);"
    
    @ipdmain-modal-show.window="()=>{
        ipdmainModal.show();
        $dispatch('swal:close');
    }"
    @ipdmain-modal-close.window="(e)=> {
        console.log(e.detail.msgstatus);
        $dispatch('swal:close');
        ipdmainModal.hide();
    }"

    @err-message.window = "(e) => {
        errors = JSON.parse(e.detail.errors);
        $dispatch('swal:close');
    }"
>

    <div id="container">
        <!-- sdate: {{ $filters['sdate'] }}
        edate: {{ $filters['edate'] }}
        shiftId: {{ $filters['shiftId'] }} -->

        <div class="mb-4 w-full border-t flex justify-between py-2 px-2" id="header">
            <div class="grid grid-cols-3 gap-4">
                <x-input.date wire:model="filters.sdate" />
                <x-input.date wire:model="filters.edate" />
                <div wire:ignore>
                <x-input.select :label="__('เลือกเวร')" wire:model="filters.shiftId">
                    <option value="0">ทั้งหมด</option>
                    <template x-for="nf in nurseshifts">
                        <option :value='nf.id' x-text='nf.nurse_shift_name'>
                        </option>
                    </template>
                </x-input.select>
                </div>
            </div>
            <div>
                <x-button.primary wire:click="new">เพิ่ม</x-button.primary>
            </div>
        </div>

        <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
        <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
            <tr>
                <th scope="col" class="px-6 py-4">ลำดับ</th>
                <th scope="col" class="px-6 py-4">Ward</th>
                <th scope="col" class="px-6 py-4">วันที่เวร</th>
                <th scope="col" class="px-6 py-4">เวร</th>
                <th scope="col" class="px-6 py-4">ยกมา</th>
                <th scope="col" class="px-6 py-4">รับใหม่</th>
                <th scope="col" class="px-6 py-4">รับย้าย</th>
                <th scope="col" class="px-6 py-4">ย้าย Ward</th>
                <th scope="col" class="px-6 py-4">จำหน่าย</th>
                <th scope="col" class="px-6 py-4">ยกไป</th>
                <th scope="col" class="px-6 py-4">ผู้บันทึก</th>
                <th scope="col" class="px-6 py-4">วันเวลาบันทึก</th>
                <th scope="col" class="px-6 py-4">คำสั่ง</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
                <tr
                    class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ward_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->nurse_shift_date }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ipd_nurse_shift_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->getin }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->getnew }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->getmove }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->moveout }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->discharge }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->getout }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->updated_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->updated_at }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                            <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                        </x-button.secondary>
                        <x-button.primary x-on:click="()=>{ location.assign('{{ route('occu.ipd.detail') }}?id={{ $row->id }}') }">
                            <x-icon.pencil-square class="w-4 h-4" /> เขียนบันทึก
                        </x-button.primary>
                        <x-button.trash wire:click="deleteConfirm('{{ $row->id }}')">
                            <x-icon.trash class="w-4 h-4" /> ลบ
                        </x-button.trash>
                    
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="whitespace-nowrap px-6 py-4 text-center font-medium">
                        -- Empty --
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($rows)
        <div class="py-4">
            {{ $rows->links() }}
        </div>
    @endif
    </div>

    <!-- Edit Modal -->
    <x-tw-modal.dialog x-ref="ipdmainModal" maxWidth="xl" wire:ignore>
        <x-slot name="title">ส่งเวร IPD</x-slot>
        <x-slot name="content">
            <div class="flex justify-between gap-2">
                <x-input.date wire:model.defer="editing.date_for_editing" />
                <x-input.tw-time id="time_edit" wire:model.defer="editing.time_for_editing" />
            </div>

            <div class="flex justify-between gap-2 mb-3">
                <div class="w-1/2">
                <x-input.select :label="__('เลือกเวร')" wire:model.defer="editing.ipd_nurse_shift_id">
                    <option value="0">-- เลือกเวร --</option>
                    <template x-for="nf in nurseshifts">
                        <option :value='nf.id' x-text='nf.nurse_shift_name'>
                        </option>
                    </template>
                </x-input.select>
                <x-error
                    x-show="errors['editing.ipd_nurse_shift_id']"
                    x-text="errors['editing.ipd_nurse_shift_id']"
                />
                </div>
                <div class="w-1/2">
                <x-input.select :label="__('เลือกสาขา')" wire:model.defer="editing.occu_ins_branch_id">
                    <option value="0">-- เลือกสาขา --</option>
                    <template x-for="branch in branchs">
                        <option :value='branch.id' x-text='branch.branch_name'>
                        </option>
                    </template>
                </x-input.select>
                </div>
            </div>

            <div>
                <x-input.tw-textarea :label="__('หมายเหตุ')" id="note" wire:model.defer="editing.note" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary data-te-modal-dismiss>ยกเลิก</x-button.secondary>
            <x-button.primary x-on:click="save">บันทึก</x-button.primary>
        </x-slot>
    </x-tw-modal.dialog>
    <!-- End Modal -->
</div>