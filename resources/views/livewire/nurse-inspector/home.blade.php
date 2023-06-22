<div>
    <div id="container">
        sdate: {{ $filters['sdate'] }}
        edate: {{ $filters['edate'] }}
        shiftId: {{ $filters['shiftId'] }}

        <div class="w-full border" id="header">
            <div class="grid grid-cols-3 gap-4">
                <x-input.date wire:model="filters.sdate" />
                <x-input.date wire:model="filters.edate" />
                <div wire:ignore>
                    <select
                        x-on:change="() => { /* $dispatch('cat:progress') */ }"
                        wire:model="filters.shiftId" data-te-select-init >
                        <option value="0">ทั้งหมด</option>
                        @foreach ($ipd_nurse_shifts as $item)
                        <option value="{{ $item->id }}">{{ $item->nurse_shift_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div id="list" class="overflow-x-auto grid grid-flow-row dark:text-white">
            <x-grid.header>
                <div class="">ลำดับ</div>
                <div class="">Status</div>
                <div class="">สาขา</div>
                <div class="">วันที่เวร</div>
                <div class="">เวร</div>
                <div class="">ผู้บันทึก</div>
                <div class="col-span-2">วันเวลาบันทึก</div>
            </x-grid.header>
            @foreach($rows as $key => $row)
            <div x-on:click="open = !open" role='button' class="grid grid-cols-8 hover:bg-neutral-100">
                <div class="">{{$key+1}}</div>
                <div class="">{{$row->id}}</div>
                <div class="">aaa</div>
                <div class="">202020</div>
                <div class="">mo</div>
                <div class="">ผู้บันทึก</div>
                <div class="col-span-2">วันเวลาบันทึก</div>
            </div>
            @endforeach
        </div>
        <div class="w-full border" id="body">

        </div>
    </div>
</div>