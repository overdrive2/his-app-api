<div>
    <div class="max-w-3xl">
        <div class="flex">
            <div class="grow text-left">
                <h2 class="w-auto inline-block px-2 text-left mb-4 font-medium text-base text-gray-700">
                    ประวัติเตียง {{ $bed->bed_name }}
                </h2>
                สถานะ: {!! $bed->empty_flag ? '<span class="text-sm flex-none border rounded px-2 bg-green-500 text-white">เตียงว่าง</span>'
                    : '<span class="text-sm flex-none border rounded px-2 bg-red-500 text-white">ไม่ว่าง</span>' !!}
            </div>
            <div class="flex-none w-auto">
                <x-button.small-gray wire:click="update">อัพเดตสถานะ</x-button.small-gray>
            </div>
        </div>
        <x-table>
        <x-slot name="header">
            <tr>
                <th class="text-center w-10">Id</th>
                <th class="text-center w-10">AN</th>
                <th class="text-center w-32">Patient</th>
                <th class="text-center w-16">Date</th>
                <th class="text-center w-16">Time</th>
                <th class="text-center w-32">Type</th>
                <th class="text-center w-32">From</th>
                <th class="text-center w-32">To</th>
                <th class="text-center">Action</th>
            </tr>
        </x-slot>
        <x-slot name="content">
            @foreach($rows as $row)
            @php
                $ipd = $row->ipd();
                $from = $row->fromRef();
                $to = $row->toRef();
            @endphp
            <x-table.row>
                <x-table.cell>{{ $row->id }}</x-table.cell>
                <x-table.cell>{{ $ipd->an }}</x-table.cell>
                <x-table.cell>{{ $ipd->patient_name }}</x-table.cell>
                <x-table.cell>{{ $row->date_for_thai }}</x-table.cell>
                <x-table.cell>{{ $row->time_for_editing }}</x-table.cell>
                <x-table.cell>{{ $row->movetype_name }}</x-table.cell>
                <x-table.cell>{{ $from ? $from->bed_name : '-' }}</x-table.cell>
                <x-table.cell>{{ $to ? $to->bed_name : '-' }}</x-table.cell>
                <x-table.cell>
                    <div class="flex gap-1">
                        <x-button.small-gray type="button">แก้ไข</x-button.small-gray>
                        <x-button.small-gray type="button">ลบ</x-button.small-gray>
                    </div>
                </x-table.cell>
            </x-table.row>
            @endforeach
        </x-slot>
        </x-table>
    </div>
</div>
