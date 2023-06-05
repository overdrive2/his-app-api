<div
    x-data = "{
        ipds:[],
    }"

    @set-ipds.window="(e) => {
        ipds = e.detail.data.data;
        console.log(ipds);
    }"
>
    {{ $open ? 'Open' : 'Close' }}
    <div class="grid grid-flow-row gap-3 mb-4 dark:text-white">
        <div class="flex gap-2">
            <div class="flex-none w-20">AN</div>
            <div class="flex none w-20">HN</div>
            <div class="grow"> Full Name</div>
        </div>
        @foreach($rows as $ipd)
        <div class="flex gap-2">
            <div class="flex-none w-20">{{ $ipd->an }}</div>
            <div class="flex-none w-20">{{ $ipd->hn }}</div>
            <div class="grow">{{ $ipd->pname.$ipd->fname.' '.$ipd->lname }}</div>
        </div>
        @endforeach
    </div>
</div>
