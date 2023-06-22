<div
    x-data="{
        selectedId : [],
        buttonDisabled: false,
        ipd: [],
        newCase: (id) => {
           ncModal.show();
            // $dispatch('cat:progress')
           // $wire.emit('new:case', id)
        },
        getNewcaseCount: async () => {
            let cnt = await $wire.getNewcaseCount();
            $dispatch('update-newcase-count', {'count':cnt})
        }
    }"
    x-init="
        ncModal = new Modal($refs.newCaseModal)
      //  getNewcaseCount()
    "
    @newcase-modal-show.window = "(e) => {
        ipd = e.detail.ipd
        ncModal.show();
    }"
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
            <div id="row{{$ipd->an}}" wire:click="new({{ $ipd->an }})"
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
    <x-tw-modal.dialog
        x-ref="newCaseModal"
        maxWidth="2xl"
    >
    <x-slot name="title">รับเข้าเตียง</x-slot>
    <x-slot name="content">
        <div id="ipd-card" class="mb-4 font-medium dark:text-gray-200 text-gray-600">
            <div>
                <h6 class="inline-block">AN: <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.an"></span></h6>
                <h6 class="inline-block">HN: <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.hn"></span></h6>
            </div>
            <div>
                <h6><span class="text-xl font-bold text-gray-700 dark:text-gray-50" x-text="ipd.patient_name"></span></h6>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <x-input.date wire:model.defer="bm.date_for_editing" />
            <x-input.tw-time
                id="time_edit"
                wire:model.defer="bm.time_for_editing"
            />
        </div>
        <h5 class="text-left text-base font-bold border-b">เลือกห้อง</h5>
        <div class="text-left overflow-x-auto mb-4">
            <x-room-menu :rows="$rooms" />
        </div>

        <h5 class="text-left text-base font-bold border-b mb-2">เลือกเตียง</h5>
        <div class="mb-4">
            <x-bed-menu wire:model.defer="bm.bed_id" />
            <x-error
                x-show="errors['bm.bed_id']"
                x-text="errors['bm.bed_id']"
            />
        </div>
    </x-slot>
    <x-slot name="footer">
    </x-slot>
    </x-tw-modal.dialog>
</div>
