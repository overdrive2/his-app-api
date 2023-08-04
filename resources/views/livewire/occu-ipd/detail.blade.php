<div 
    x-data="{
        errors:[],
        save: () => {
            $dispatch('cat:progress');
            $wire.save();
        },
        edit: (id) => {
            $dispatch('cat:progress');
            $wire.edit(id);
        }
    }" 
    
    x-init="ipddetailModal = new Modal($refs.ipddetailModal);"
    
    @ipddetail-modal-show.window="()=>{
        errors = [];
        ipddetailModal.show();
        $dispatch('swal:close');
    }"
    @ipddetail-modal-close.window="(e)=> {
        console.log(e.detail.msgstatus);
        $dispatch('swal:close');
        ipddetailModal.hide();
    }"

    @err-message.window = "(e) => {
        errors = JSON.parse(e.detail.errors);
        $dispatch('swal:close');
        console.log(errors);
    }"
>
    <div id="container">
    <div class="mb-4 w-full border-t flex justify-between py-2 px-2" id="header">
            <div class="flex gap-2 text-lg">
                <div>วันที่ : <span class="font-semibold">{{ $occuIpd->date_for_thai }}</span></div>
                <div>เวร : <span class="font-semibold">{{ $occuIpd->ipd_nurse_shift_name }}</span></div>
                <div>Ward : <span class="font-semibold">{{ $occuIpd->ward_name }}</span></div>
            </div>
            <div>
                <x-button.primary wire:click="new">เขียนบันทึก</x-button.primary>
            </div>
        </div>

        <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
        <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
            <tr>
                <th scope="col" class="px-6 py-4">ลำดับ</th>
                <th scope="col" class="px-6 py-4">an</th>
                <th scope="col" class="px-6 py-4">เตียง</th>
                <th scope="col" class="px-6 py-4">ประเภท</th>
                <th scope="col" class="px-6 py-4">วันเวลา</th>
                <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
                <tr
                    class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->an }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->bedmove()->bed_name ?? '' }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->occu_ipd_type_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->moved_at }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                            <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                        </x-button.secondary>
                        <x-button.primary x-on:click="()=>{ location.assign('{{ route('occu.ipd.detail') }}?id={{ $row->id }}') }">
                            <x-icon.pencil-square class="w-4 h-4" /> แสดงรายการ
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
    <x-tw-modal.dialog x-ref="ipddetailModal" maxWidth="xl" wire:ignore>
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
                <x-input.select :label="__('เลือกตึก')" wire:model.defer="editing.ward_id">
                    <option value="0">-- เลือกตึก --</option>
                    <template x-for="ward in wards">
                        <option :value='ward.id' x-text='ward.name'>
                        </option>
                    </template>
                </x-input.select>
                <x-error
                    x-show="errors['editing.ward_id']"
                    x-text="errors['editing.ward_id']"
                />
                </div>
            </div>

            <div>
                <x-input.tw-textarea :label="__('หมายเหตุ')" id="note" wire:model.defer="editing.note" />
            </div>
            <x-error
                    x-show="errors['editing.nurse_shift_date']"
                    x-text="errors['editing.nurse_shift_date']"
            />
        </x-slot>
        
        <x-slot name="footer">
            <x-button.secondary data-te-modal-dismiss>ยกเลิก</x-button.secondary>
            <x-button.primary x-on:click="save">บันทึก</x-button.primary>
        </x-slot>
    </x-tw-modal.dialog>
    <!-- End Modal -->
</div>