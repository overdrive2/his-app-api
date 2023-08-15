<div
    x-data="{
        edit: async (id) => {
            await $wire.edit(id)
            edModal.show()
        },
        save: () => {
            $dispatch('cat:progress')
            $wire.save()
          //  $dispatch.('swal:close')
        }
    }"
    x-init="
        edModal = new Modal($refs.edModal)
    "
    @close-mdmodal.window="()=>{
        edModal.hide();
        $dispatch('swal:close');
        $dispatch('toastify');
    }"
>
    <div class="flex justify-between">
        <div class="w-1/2">
            <div class="mb-3">
                <input
                type="search"
                wire:model.debouncer.500ms="search"
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                id="Search"
                placeholder="ค้นหา..." />
            </div>
        </div>
        <div class="w-1/2 text-right">
            <x-input.tw-toggle
                id="filterActive"
                wire:model="active"
                label="ที่เปิดใช้งาน"
            />
        </div>
    </div>
    <div class="relative">
        <div wire:loading.delay wire:loading wire:target="search" class="absolute top-1/2 left-1/2">
            <x-spinner />
            <h6 class="ml-5 mt-2 text-base text-gray-500">Loading...</h6>
        </div>
        <div wire:target="search" wire:loading.class="opacity-25">
            <div class="flex flex-col overflow-x-auto">
                <div class="sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                        <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b font-medium dark:border-neutral-500 dark:text-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4">ID</th>
                                <th scope="col" class="px-6 py-4">ICODE</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Type</th>
                                <th scope="col" class="px-6 py-4">Heading</th>
                                <th scope="col" class="px-6 py-4">Heading</th>
                                <th scope="col" class="px-6 py-4">Heading</th>
                                <th scope="col" class="px-6 py-4">Active</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $item)
                                <tr class="border-b dark:border-neutral-500 dark:text-gray-100">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $item->id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $item->icode }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $item->iname }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">Cell</td>
                                    <td class="whitespace-nowrap px-6 py-4">Cell</td>
                                    <td class="whitespace-nowrap px-6 py-4">Cell</td>
                                    <td class="whitespace-nowrap px-6 py-4">Cell</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {!! $item->active ? '<span class="text-primary dark:text-primary-200">Yes</span>' : '<span class="text-danger dark:text-danger-200">No</span>' !!}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex gap-2">
                                            <button
                                                x-on:click="edit({{$item->id}})"
                                                type="button"
                                                data-te-ripple-init
                                                data-te-ripple-color="light"
                                                class="inline-block rounded-full bg-primary h-8 w-8 text-white">
                                                <i class="fa-solid fa-square-pen text-base"></i>
                                            </button>
                                            <button
                                                type="button"
                                                data-te-ripple-init
                                                data-te-ripple-color="light"
                                                class="inline-block rounded-full bg-primary h-8 w-8 uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                            >
                                                <i class="fa-solid fa-trash-can text-base"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-tw-modal.dialog
        x-ref="edModal"
        maxWidth="xl"
        wire:ignore
    >
    <x-slot name="title">Edit Modal</x-slot>
    <x-slot name="content">
        <!-- Data Control -->
        <x-input.tw-text label="Name" wire:model.defer="editing.iname" />
        <x-input.tw-toggle
            id="drugActive"
            wire:model.defer="editing.active"
            label="เปิดใช้งาน"
        />
        <x-input.date wire:model.defer="date" />
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
