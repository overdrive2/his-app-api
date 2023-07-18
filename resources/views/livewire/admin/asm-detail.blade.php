<div
    x-data="{
        newasm:() => {
            $dispatch('cat:progress')
            $wire.new();
        },
        edit:(id) => {
            $dispatch('cat:progress')
            $wire.edit(id);
        },
        save:() => {
            $dispatch('cat:progress')
            $wire.save();
        }
    }"

    x-init="
        edModal = new Modal($refs.edModal)
    "
    @edmodal-show.window="() => {
        setTimeout(() => {
            $dispatch('swal:close')
            edModal.show()
        }, 1000)
    }"
>
    <div class="flex justify-between gap-2">
        <div class="lg:w-1/2 w-full"></div>
        <div class="w-full lg:w-1/2 text-right">
            <x-button.primary x-on:click="newasm">New</x-button.primary>
        </div>
    </div>
    <x-table>
        <x-slot name="header">
            <tr>
                <th scope="col" class="px-6 py-4 text-center">ID</th>
                <th scope="col" class="px-6 py-4">Name</th>
            </tr>
        </x-slot>
        <x-slot name="content">
            @foreach($rows as $key => $row)
            <x-table.row :key="$key">
                <x-table.cell class="text-center">{{ $row->id }}</x-table.cell>
                <x-table.cell>{{ $row->web_label }}</x-table.cell>
                <x-table.cell>
                    <div class="flex justify-center gap-2">
                        <x-button.secondary x-on:click="edit('{{ $row->id }}')">
                            <x-icon.pencil-square class="w-4 h-4" /> แก้ไข
                        </x-button.secondary>
                        <x-button.secondary wire:click="deleteConfirm('{{ $row->id }}')">
                            <x-icon.trash class="w-4 h-4" /> ลบ
                        </x-button.secondary>
                    </div>
                </x-table.cell>
            </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
    <!-- Edit Modal -->
    <x-tw-modal.dialog
        x-ref="edModal"
        maxWidth="xl"
        wire:ignore
    >
    <x-slot name="title">Edit Modal</x-slot>
    <x-slot name="content">
        <!-- Data Control -->
        <x-input.tw-text label="Name" wire:model.defer="editing.web_label"/>
        <div>
            <x-input.tw-toggle label="parent" wire:model.defer="editing.web_label" />
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
