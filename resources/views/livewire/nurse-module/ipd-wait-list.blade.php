<div
    x-data="{
        errors:[],
        ipd: [],
        recpCase: async (id) => {
            $dispatch('cat:progress')
            $wire.new(id);
        },
        save: () => {
            $dispatch('cat:progress')
            $wire.save()
        }
    }"
    x-init="
        wcModal = new Modal($refs.wcModal)
    "
    @waitcase-modal-show.window = "(e) => {
        ipd = e.detail.ipd;
        setTimeout(() => {
            $dispatch('swal:close')
            wcModal.show()
        }, 1000);
    }"

    @waitcase-modal-hide.window = "(e) => {
        setTimeout(() => {
            wcModal.hide();
            $dispatch('swal:close')
            $wire.emit('wait:refresh');
        }, 1000)
    }"

    @err-message.window = "(e) => {
        errors = JSON.parse(e.detail.errors);
        setTimeout(() => $dispatch('swal:close'), 1000);
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
            <x-table.row
                role="button"
                :key="$key"
                id="row{{$row->an}}"
                x-on:click="recpCase('{{$row->id}}')"
                role="button"
                class="hover:bg-neutral-100 dark:hover:bg-neutral-700"
            >
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
    <x-tw-modal.dialog
        x-ref="wcModal"
        maxWidth="2xl"
        wire:ignore
    >
    <x-slot name="title">รับเข้าเตียง</x-slot>
    <x-slot name="content">
        <div id="ipd-card-wait" class="mb-4 font-medium dark:text-gray-200 text-gray-600">
            <div>
                <h6 class="inline-block">AN: <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.an"></span></h6>
                <h6 class="inline-block">HN: <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.hn"></span></h6>
            </div>
            <div>
                <h6><span class="text-xl font-bold text-gray-700 dark:text-gray-50" x-text="ipd.patient_name"></span></h6>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <x-input.date wire:model.defer="editing.date_for_editing" />
            <x-input.tw-time
                id="time_edit"
                wire:model.defer="editing.time_for_editing"
            />
        </div>
        <h5 class="text-left text-base font-bold border-b">เลือกห้อง</h5>
        <div class="text-left overflow-x-auto mb-4">
            <x-room-menu :rows="$rooms" />
        </div>
        <h5 class="text-left text-base font-bold border-b mb-2">เลือกเตียง</h5>
        <div class="mb-4">
            <x-bed-menu wire:model.defer="editing.bed_id" />
            <x-error
                x-show="errors['editing.bed_id']"
                x-text="errors['editing.bed_id']"
            />
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary @click="() => wcModal.hide()">ยกเลิก</x-button.secondary>
        <x-button.primary
            x-on:click="save"
        >บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
