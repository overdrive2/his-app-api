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
    }" x-init="
        ipddetailModal = new Modal($refs.ipddetailModal);
    " @ipddetail-modal-show.window="()=>{
        errors = [];
        ipddetailModal.show();
        $dispatch('swal:close');
    }" @ipddetail-modal-close.window="(e)=> {
        console.log(e.detail.msgstatus);
        $dispatch('swal:close');
        ipddetailModal.hide();
    }" @err-message.window="(e) => {
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
                <!-- <x-button.primary wire:click="new">เพิ่มรายการ</x-button.primary> -->
                @if ($occuIpd->saved == false)
                <x-button.success wire:click="confirmCommit">ยืนยันส่งเวร</x-button.success>
                @elseif ($occuIpd->saved == true)                
                <x-button.trash wire:click="confirmCommit">ยกเลิกยืนยัน</x-button.trash>
                @endif
            </div>
        </div>

        <div class="flex lg:flex-row flex-col justify-between">
            <div class="lg:w-1/2 w-full">
                @livewire('occu-ipd.detail-staff', ['occu_ipd_id' => $occuIpd->id,'saved' => $occuIpd->saved],key('detailStaff'.$occuIpd->id))
            </div>
            <div class="lg:w-1/2 w-full">
                @livewire('occu-ipd.detail-record', ['occu_ipd_id' => $occuIpd->id,'saved' => $occuIpd->saved],key('detailRecord'.$occuIpd->id))

            </div>

        </div>
        <!-- detail part -->
        <div class="flex flex-col lg:flex-row justify-start gap-2">
            <div>
                <strong>ประเภท</strong>
                <button wire:click="$set('pageId',0)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 0 ? 'bg-gray-300':'' }}"><i class="fa-regular fa-rectangle-list"></i> ทั้งหมด {{ $this->RowCount }}</button>
                <button wire:click="$set('pageId',1)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 1 ? 'bg-gray-300':'' }}"><i class="fa-solid fa-retweet"></i> ยกมา {{ $occuIpd->getin }}</button>
                <button wire:click="$set('pageId',2)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 2 ? 'bg-gray-300':'' }}"><i class="fa-solid fa-user-plus"></i> รับใหม่ {{ $occuIpd->getnew }}</button>
                <button wire:click="$set('pageId',3)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 3 ? 'bg-gray-300':'' }}"><i class="fa-solid fa-user-clock"></i> รับย้าย {{ $occuIpd->getmove }}</button>
                <button wire:click="$set('pageId',4)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 4 ? 'bg-gray-300':'' }}"><i class="fa-solid fa-person-walking-dashed-line-arrow-right"></i> ย้าย Ward {{ $occuIpd->moveout }}</button>
                <button wire:click="$set('pageId',5)" class="border px-2 py-1 rounded-md shadow-md {{ $pageId == 5 ? 'bg-gray-300':'' }}"><i class="fa-solid fa-house-user"></i> จำหน่าย {{ $occuIpd->discharge }}</button>
            </div>
            <div>
                <strong>ความรุนแรง</strong>
                <button wire:click="$set('pageSvId',0)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 0 ? 'bg-gray-300':'' }}"><i class="fa-regular fa-rectangle-list"></i> ทั้งหมด {{ $this->RowCount }}</button>
                <button wire:click="$set('pageSvId',1)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 1 ? 'bg-gray-300':'' }}"> <strong>ป.1</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_1 }} </span></button>
                <button wire:click="$set('pageSvId',2)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 2 ? 'bg-gray-300':'' }}"> <strong>ป.2</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_2 }}</button>
                <button wire:click="$set('pageSvId',3)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 3 ? 'bg-gray-300':'' }}"> <strong>ป.3</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_3 }}</button>
                <button wire:click="$set('pageSvId',4)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 4 ? 'bg-gray-300':'' }}"> <strong>ป.4</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_4 }}</button>
                <button wire:click="$set('pageSvId',5)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 5 ? 'bg-gray-300':'' }}"> <strong>ป.5</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_5 }}</button>
                <button wire:click="$set('pageSvId',6)" class="border px-2 py-1 rounded-md shadow-md {{ $pageSvId == 6 ? 'bg-gray-300':'' }}"> <strong>ป.6</strong> <span class="font-bold bg-red-600 text-white inline-block px-2 rounded-full border">{{ $occuIpd->severe_6 }}</button>
            </div>
        </div>

        <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
            <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
                <tr>
                    <th scope="col" class="px-6 py-4">ลำดับ</th>
                    <th scope="col" class="px-6 py-4">an</th>
                    <th scope="col" class="px-6 py-4">ชื่อ-สกุลผู้ป่วย</th>
                    <th scope="col" class="px-6 py-4">ความรุนแรง</th>
                    <th scope="col" class="px-6 py-4">ประเภท</th>
                    <th scope="col" class="px-6 py-4">เตียง</th>
                    <th scope="col" class="px-6 py-4">ประเภท</th>
                    <th scope="col" class="px-6 py-4">วันเวลาย้ายเตียง</th>
                    <!-- <th scope="col" class="px-6 py-4 text-center">คำสั่ง</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $key => $row)
                @php
                $bedmove = $row->bedmove();
                $ipd = $bedmove->ipd();
                @endphp
                <tr class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $ipd->an }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $ipd->patient_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ipd_severe_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ipd_admit_type_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $bedmove->bed_name ?? '' }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->occu_ipd_type_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $bedmove->moved_at }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <!-- <x-button.trash wire:click="deleteConfirm('{{ $row->id }}')">
                            <x-icon.trash class="w-4 h-4" /> ลบ
                        </x-button.trash> -->

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