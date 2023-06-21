<div
    x-data="{
        buttonDisabled: false,
    }"
>
    {{ $ward_id }}
        <div id="list" class="overflow-x-auto grid grid-flow-row dark:text-white">
        <div class="flex gap-2">
            <div class="flex-none w-24">Date</div>
            <div class="flex-none w-20">Time</div>
            <div class="flex-none w-20">AN</div>
            <div class="flex-none w-20">HN</div>
            <div class="grow">ชื่อ - นามสกุล</div>
        </div>
        @foreach ($rows as $row)
            <div id="row{{$row->an}}" x-on:click="newCase({{$row->an}})"
                class="flex border-b gap-2 dark:border-gray-500 dark:hover:bg-gray-700 hover:bg-gray-100 py-2" role="button" x-bind:disabled="buttonDisabled" >
                <div class="flex-none w-24">{{ $row->movedate }}</div>
                <div class="flex-none w-20">{{ $row->movetime }}</div>
                <div class="flex-none w-20">{{ $row->an }}</div>
                <div class="flex-none w-20">{{ $row->hn }}</div>
                <div class="grow text-left min-w-[160px]">{{ $row->pname . $row->fname . ' ' . $row->lname }}</div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $rows ? $rows->links() : ''}}
    </div>
</div>
