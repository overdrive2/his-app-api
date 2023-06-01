<div
    x-data="{
        wards: @js($wards),
        search: @entangle('search_ward'),
        newWard: () => {
            modal.show()
        },
        selectWard: (id) => {
            $wire.emit('select:ward', id);
        }
    }"

    @set-wards.window="(e) => {
        wards = e.detail.wards
    }"

    @hide-modal.window="(e) => {
        modal.hide()
        if(e.detail.status == 200) $dispatch('toastify')
    }"

    x-init = "
        modal = new Modal($refs.searchModal);
    "
    class="dark:text-gray-200"
>
    <h4>Ward Uid {{ $uid }}</h4>
    <div>
        <div>
            <x-button.primary x-on:click="newWard">
                เพิ่ม
            </x-button.primary>
        </div>
        <table class="max-w-3xl w-full">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Ward name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $key => $row)
                <tr>
                    <th>{{ $key +1  }}</th>
                    <th>{{ $row->ward_name }}</th>
                    <th>
                        <x-button.edit>Edit</x-button.edit>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div
        x-ref="searchModal"
        wire:ignore data-te-modal-init class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalScrollableLabel" aria-hidden="true">
        <div data-te-modal-dialog-ref class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalScrollableLabel">
                        Modal title
                    </h5>
                    <!--Close button-->
                    <button type="button" class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none" data-te-modal-dismiss aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!--Modal body-->
                <div class="mt-2 w-full sticky top-0 px-4">
                    <div class="relative mb-3 px-4" data-te-input-wrapper-init>
                        <div class="absolute right-0 top-0 mt-1 mr-2" wire:loading wire:target="search_ward">
                            <div class="inline-block h-6 w-6 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] text-primary motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                            </div>
                        </div>
                        <input autofocus wire:model.debounce.600ms="search_ward" type="search" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="searchWard" placeholder="ค้นหา..." />
                    </div>
                </div>
                <div class="relative overflow-y-auto p-4">
                    <ul class="w-full">
                        <template x-for="ward in wards">
                            <li x-bind:disabled="true" x-html="ward.name.replace(search, '<span class=\'text-red-400\'>'+search+'</span>')" class="px-4 text-left w-full border-b-2 border-neutral-100 border-opacity-100 py-4 dark:border-opacity-50 hover:dark:bg-slate-500 hover:bg-slate-100 cursor-pointer" x-on:click="selectWard(ward.id)">
                            </li>
                        </template>
                    </ul>
                </div>

                <!--Modal footer-->
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
