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
    @edmodal-show="() => {
        setTimeout(() => {
            $dispatch('swal:close')
            edModal.show()
        }, 1000)
    }"
>
    <div class="flex justify-between gap-2">
        <div class="lg:w-1/2 w-full"></div>
        <div class="w-full lg:w-1/2 text-right py-1">
            <x-button.primary x-on:click="newasm">New Section</x-button.primary>
        </div>
    </div>
    <div class="mt-2 flex flex-col gap-2">
        @foreach($rows as $key => $row)
            @livewire('admin.asm-detail', [
                    'form_id' => 1,
                    'section' => $row,
                    'section_id' => $row->id
            ], key('section-'.$row->id))
        @endforeach
    </div>
    <!-- Edit Modal -->
    <x-tw-modal.dialog
        x-ref="edModal"
        maxWidth="xl"
        wire:ignore
    >
    <x-slot name="title">Edit Modal</x-slot>
    <x-slot name="content">
        <!-- Data Control -->
        <x-input.tw-text label="Name" wire:model.defer="editing.name"/>
        <x-input.tw-text label="Parent Id" wire:model.defer="editing.parent_id" />
        <x-input.tw-text label="Column" wire:model.defer="editing.col" />
        <x-input.tw-text label="Display order" wire:model.defer="editing.display_order" />
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
