<div
    x-data="{
        buttonDisabled: false,
        newCase: (an) => {
            $dispatch('cat:progress')
            $wire.emit('new:case', an)
        },
        getNewcaseCount: async () => {
            let cnt = await $wire.getNewcaseCount();
            $dispatch('update-newcase-count', {'count':cnt})
        }
    }"
    x-init="
        getNewcaseCount()
    "
>
    <div id="list" class="overflow-x-auto grid grid-flow-row dark:text-white">
        <div class="flex gap-2">
            <div class="flex-none w-24">Date</div>
            <div class="flex-none w-20">Time</div>
            <div class="flex-none w-20">AN</div>
            <div class="flex-none w-20">HN</div>
            <div class="grow">ชื่อ - นามสกุล</div>
        </div>
        @foreach ($rows as $ipd)
            <div id="row{{$ipd->an}}" x-on:click="newCase({{$ipd->an}})"
                class="flex border-b gap-2 dark:border-gray-500 dark:hover:bg-gray-700 hover:bg-gray-100 py-2" role="button" x-bind:disabled="buttonDisabled" >
                <div class="flex-none w-24">{{ $ipd->reg_date_thai }}</div>
                <div class="flex-none w-20">{{ $ipd->regtime }}</div>
                <div class="flex-none w-20">{{ $ipd->an }}</div>
                <div class="flex-none w-20">{{ $ipd->hn }}</div>
                <div class="grow text-left min-w-[160px]">{{ $ipd->pname . $ipd->fname . ' ' . $ipd->lname }}</div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $rows ? $rows->links() : ''}}
    </div>
</div>
