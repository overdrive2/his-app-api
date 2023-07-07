<div>
    <div id="container">
        {{ $occu_ins_id }}
        <div class="mb-4 w-full border-t flex justify-between py-2 px-2" id="header">
            <div class="flex gap-2 text-lg">
                <div>วันที่ : <span class="font-semibold">{{ $occuIns->date_for_thai }}</span></div>
                <div>เวร : <span class="font-semibold">{{ $occuIns->ipd_nurse_shift_name }}</span></div>
                <div>สาขา : <span class="font-semibold">{{ $occuIns->occu_ins_branch_name }}</span></div>
            </div>
            <div>
                <x-button.primary wire:click="new">เขียนบันทึก</x-button.primary>
            </div>
        </div>

        <div class="lg:flex gap-2 hidden">
            <div class="flex-none w-12">
                <div class="border rounded-md shadow-md">
                    ลำดับ
                </div>
            </div>
            <div class="grow">
                <div class="lg:flex gap-4 justify-between mb-2">
                    <div class="lg:w-1/2 lg:min-w-[250px] w-full border rounded-md shadow-md mb-2">
                        เหตุการณ์
                    </div>
                    <div class="lg:w-1/2 lg:min-w-[250px] w-full border rounded-md shadow-md mb-2">
                        การแก้ปัญหา
                    </div>
                </div>
            </div>
            <div class="flex-none w-full max-w-sm">
                <div class="flex gap-2 justify-between">
                    <div class="border rounded-md shadow-md text-center w-full">
                        การบันทึก
                    </div>
                    <div class="border rounded-md shadow-md text-center w-full">
                        คำสั่ง
                    </div>
                </div>
            </div>
        </div>
        @foreach($rows as $key => $row)
        <div class="lg:flex gap-2 border border-b mb-2 p-2">
            <div class="lg:flex-none lg:w-8 flex w-full lg:bg-white bg-primary lg:text-black text-white px-2">
                <span class="lg:hidden font-semibold mr-4">ลำดับ</span>
                <span class="font-semibold">{{ $key+1 }}</span>
                
            </div>
            <div class="grow">
                <div class="lg:flex gap-4 justify-between">
                    <div class="lg:w-1/2 lg:min-w-[250px] w-full border rounded-md shadow-md mb-2">
                        <h3 class="lg:hidden font-semibold">เหตุการณ์</h3>
                        <div class="whitespace-pre-line max-h-40 overflow-y-auto">{{ $row->occu_ins_event }}</div>
                    </div>
                    <div class="lg:w-1/2 lg:min-w-[250px] w-full border rounded-md shadow-md mb-2">
                        <h3 class="lg:hidden font-semibold">การแก้ปัญหา</h3>
                        <div class="whitespace-pre-line max-h-40 overflow-y-auto">{{ $row->occu_ins_solve }}</div>
                    </div>
                </div>
            </div>
            <div class="flex-none w-full max-w-sm">
                <div class="flex gap-2 justify-between">
                    <div>
                    <h3 class="lg:hidden font-semibold">การบันทึก</h3>    
                        <div>{{ $row->updated_name }}</div>
                        <div>{{ $row->updated_at }}</div>
                    </div>
                    <div>
                    <h3 class="lg:hidden font-semibold">คำสั่ง</h3>   
                        <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                            <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                        </x-button.secondary>
                        <x-button.trash x-on:click="edit('{{ $row->id }}')">
                            <x-icon.trash class="w-4 h-4" /> ลบ
                        </x-button.trash>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>