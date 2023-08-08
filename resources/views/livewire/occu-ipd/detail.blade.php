<div x-data="{
        errors:[],
        save: () => {
            $dispatch('cat:progress');
            $wire.save();
        },
        commit: () => {
            $dispatch('cat:progress');
            $wire.commit();
        }
    }" 
    
    x-init="
        ipddetailModal = new Modal($refs.ipddetailModal);
    " 
    
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
    
    @err-message.window="(e) => {
        errors = JSON.parse(e.detail.errors);
        $dispatch('swal:close');
        console.log(errors);
    }">

    <div id="container">
        <div class="mb-4 w-full border-t flex justify-between py-2 px-2" id="header">
            <div class="flex gap-2 text-lg">
                <div>วันที่ : <span class="font-semibold">{{ $occuIpd->date_for_thai }}</span></div>
                <div>เวร : <span class="font-semibold">{{ $occuIpd->ipd_nurse_shift_name }}</span></div>
                <div>Ward : <span class="font-semibold">{{ $occuIpd->ward_name }}</span></div>
            </div>
            <div>
                <x-button.primary wire:click="new">เพิ่มรายการ</x-button.primary>
                <x-button.success wire:click="confirmCommit">ยืนยันส่งเวร</x-button.success>
            </div>
        </div>

        <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
            <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-4">ลำดับ</th>
                    <th scope="col" class="px-6 py-4">an</th>
                    <th scope="col" class="px-6 py-4">เตียง</th>
                    <th scope="col" class="px-6 py-4">ประเภท</th>
                    <th scope="col" class="px-6 py-4">วันเวลาย้ายเตียง</th>
                    <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $key => $row)
                <tr class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->an }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->bedmove()->bed_name ?? '' }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->occu_ipd_type_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->bedmove()->moved_at }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
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
</div>