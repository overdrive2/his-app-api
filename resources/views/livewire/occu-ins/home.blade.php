<div 
    x-data="{
        errors:[],
        nurseshifts: @js($nurseshifts),
        branchs: @js($branchs),
        save: () => {
            $dispatch('cat:progress');
            $wire.save();
        },
        edit: (id) => {
            $dispatch('cat:progress');
            $wire.edit(id);
        }
    }" 
    
    x-init="insmainModal = new Modal($refs.insmainModal);"
    
    @insmain-modal-show.window="()=>{
        insmainModal.show();
        $dispatch('swal:close');
    }"
    @insmain-modal-close.window="(e)=> {
        console.log(e.detail.msgstatus);
        $dispatch('swal:close');
        insmainModal.hide();
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

        <div id="list" class="mt-2 overflow-x-auto grid grid-flow-row dark:text-white">
            <x-grid.header>
                <div class="">ลำดับ</div>
                <div class="">สถานะ</div>
                <div class="">สาขา</div>
                <div class="">วันที่เวร</div>
                <div class="">เวร</div>
                <div class="">ผู้บันทึก</div>
                <div class="">วันเวลาบันทึก</div>
                <div class="text-center">คำสั่ง</div>
            </x-grid.header>
            @foreach($rows as $key => $row)
            <div x-on:click="open = !open" role='button' class="grid grid-cols-8 hover:bg-neutral-100">
                <div class="">{{$key+1}}</div>
                <div class="">{{$row->occu_status_name}}</div>
                <div class="">{{$row->occu_ins_branch_name}}</div>
                <div class="">{{$row->nurse_shift_date}}</div>
                <div class="">{{$row->ipd_nurse_shift_name}}</div>
                <div class="">{{$row->updated_name}}</div>
                <div class="">{{$row->updated_at}}</div>
                <div class="py-1">
                    <div class="flex gap-2">
                        <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                            <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                        </x-button.secondary>
                        <x-button.primary x-on:click="()=>{ location.assign('{{ route('occu.ins.detail') }}?id={{ $row->id }}') }">
                            <x-icon.pencil-square class="w-4 h-4" /> เขียนบันทึก
                        </x-button.primary>
                        <x-button class="bg-red-600 bg-opacity-80" wire:click="deleteConfirm('{{ $row->id }}')">
                            <x-icon.trash class="w-4 h-4" /> ลบ
                        </x-button>
                    </div> 
                </div>
            </div>
            @endforeach
        </div>
        <div>
            {{ $rows->links() }}
        </div>
    </div>

    <!-- Edit Modal -->
    <x-tw-modal.dialog x-ref="insmainModal" maxWidth="xl" wire:ignore>
        <x-slot name="title">การบันทึกเหตุการณ์ทางพยาบาล</x-slot>
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