<div
    x-data="{
        buttonDisabled: false,
        newCase:(an)=>{
            console.log(an)
        }
    }"
>
    <x-table>
        <x-slot name="header">
            <tr>
                <th scope="col" class="px-2 flex-none w-[100px]">Date</th>
                <th scope="col" class="px-2 flex-none w-20">Time</th>
                <th scope="col" class="px-2 flex-none w-20">AN</th>
                <th scope="col" class="px-2 flex-none w-20">HN</th>
                <th scope="col" class="px-2 grow text-left">ชื่อ - นามสกุล</th>
            </tr>
        </x-slot>
        <x-slot name="content">
        @foreach ($rows as $key => $row)
            @php
                $ipd = $row->ipd ?? '';
            @endphp
            <x-table.row role="button" :key="$key" id="row{{$row->an}}" x-on:click="newCase('{{$ipd->id}}')" role="button" x-bind:disabled="buttonDisabled" >
                <x-table.cell class="px-2 flex-none w-[100px]">{{ $row->movedate }}</x-table.cell>
                <x-table.cell class="px-2 flex-none w-20">{{ $row->movetime }}</x-table.cell>
                <x-table.cell class="px-2 flex-none w-20">{{ $ipd->an }}</x-table.cell>
                <x-table.cell class="px-2 flex-none w-20">{{ $ipd->hn }}</x-table.cell>
                <x-table.cell class="px-2 grow text-left min-w-[160px]">{{ $ipd->patient_name }}</x-table.cell>
            </x-table.row>
        @endforeach
        </x-slot>
    </x-table>
    <div>
        {{ $rows ? $rows->links() : ''}}
    </div>
</div>
