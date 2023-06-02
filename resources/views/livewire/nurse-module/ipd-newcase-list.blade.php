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
    <div class="grid grid-flow-row gap-3 mb-4">
        @foreach($rows as $ipd)
       <div class="flex gap-2">
            <div class="flex-none w-20">{{$ipd->an}}</div>
            <div class="grow h-14"></div>
            <div class="flex-none w-20"></div>
        </div>
        @endforeach
    </div>
</div>
