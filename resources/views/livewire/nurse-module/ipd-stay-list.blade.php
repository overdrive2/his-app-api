<div
    x-data = "{
        ward : [],
        rooms : [],
        beds :$wire.beds,
        open :$wire.open,
        ipd:[],
        showActionModal: (row) => {
            selectedId = row.id;
            $dispatch('set-ipd', {ipd : row.ipd});
            acModal.show();
        }
    }"

    x-init = "
        acModal = new Modal($refs.ipdActionModal)
        $wire.loadData()
    "

    @set-staydata.window="(e) => {
        data = e.detail;
        ward = data.ward;
        rooms = data.rooms;
        beds = data.beds;
        console.log(open);
    }"

    @set-ipd.window="(e) => ipd = e.detail.ipd"
>
    <div x-show="open">
        <div class="flex justify-between">
            <div>เตียง <span x-text="ward.name"></span></div>
            <div class="text-right flex gap-1">
                <x-button.icon>
                    <i class="fa-solid fa-list text-xl text-neutral-500"></i>
                </x-button.icon>
                <x-button.icon>
                    <i class="fa-solid fa-bed-pulse text-xl text-neutral-500"></i>
                </x-button.icon>
            </div>
        </div>
        <div class="grid lg:grid-cols-6 grid-cols-1 gap-4 font-mono text-white text-sm text-center font-bold leading-6 bg-stripes-fuchsia rounded-lg">
            <template x-for="bed in beds">
                <div class="relative">
                    <div
                        x-on:click.prevent="showActionModal(bed)"
                        data-te-ripple-color="light"
                        role="button" class="flex p-4 rounded-lg shadow-lg"
                        :class="(bed.ipd ?? []).length == 0 ? 'bg-gray-600' : (selectedId == bed.id ? 'border-b-4 border-green-800 bg-green-800':'bg-green-600')" >
                        <div x-text="bed.bed_name" class="text-2xl font-bold flex-none"></div>
                        <div class="grow">
                            <div x-text="bed.ipd ? bed.ipd.an : ''" class="w-full text-lg"></div>
                            <div x-text="bed.ipd ? bed.ipd.patient_name : ''" class="w-full text-base"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <!--Verically centered modal-->
    <div
        x-ref="ipdActionModal"
        data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="ipdActionMenu"
        tabindex="-1"
        aria-labelledby="ipdActionMenuTitle"
        aria-modal="true"
        role="dialog"
    >
        <div
            data-te-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]"
        >
            <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5
                        class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                        id="ipdActionMenuTitle"
                    >
                        IPD Actions Menu
                    </h5>
                    <!--Close button-->
                    <button
                        type="button"
                        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                        data-te-modal-dismiss
                        aria-label="Close"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-6 w-6">
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!--Modal body-->
                <div class="relative p-4">
                    <h5
                        class="text-left text-base font-lg leading-normal text-neutral-800 dark:text-neutral-200"
                    >
                        <span x-text="'AN '+ ipd.an"></span>
                        <span x-text="ipd.patient_name"></span>
                    </h5>
                    <div class="w-full dark:text-white">
                        <button
                          aria-current="true"
                          type="button"
                          class="border-b border-sky-800 block w-full cursor-pointer rounded-lg p-4 text-left transition duration-500 hover:bg-neutral-100 hover:text-neutral-500 focus:bg-neutral-100 focus:text-neutral-500 focus:ring-0 dark:hover:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:bg-neutral-600 dark:focus:text-neutral-200">
                          <i class="fa-solid fa-right-left text-lg mr-2 text-sky-600"></i> ย้ายเตียง
                        </button>
                        <button
                          type="button"
                          class="border-b border-orange-800 block w-full cursor-pointer rounded-lg p-4 text-left transition duration-500 hover:bg-neutral-100 hover:text-neutral-500 focus:bg-neutral-100 focus:text-neutral-500 focus:ring-0 dark:hover:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:bg-neutral-600 dark:focus:text-neutral-200">
                          <i class="fa-solid fa-person-walking-dashed-line-arrow-right text-lg mr-2 text-orange-600"></i> ย้ายวอร์ด
                        </button>
                        <button
                          type="button"
                          class="border-b border-pink-800 block w-full cursor-pointer rounded-lg p-4 text-left transition duration-500 hover:bg-neutral-100 hover:text-neutral-500 focus:bg-neutral-100 focus:text-neutral-500 focus:ring-0 dark:hover:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:bg-neutral-600 dark:focus:text-neutral-200">
                          <i class="fa-solid fa-file-waveform text-lg mr-2 text-pink-600 dark:text-pink-400"></i> ASM
                        </button>
                        <button
                          type="button"
                          class="border-b border-green-800 block w-full cursor-pointer rounded-lg p-4 text-left transition duration-500 hover:bg-neutral-100 hover:text-neutral-500 focus:bg-neutral-100 focus:text-neutral-500 focus:ring-0 dark:hover:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:bg-neutral-600 dark:focus:text-neutral-200">
                          <i class="fa-solid fa-house-chimney-user text-lg mr-2 text-green-600"></i> จำหน่าย
                        </button>
                      </div>
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button
                    type="button"
                    class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                    data-te-modal-dismiss
                    data-te-ripple-init
                    data-te-ripple-color="light">
                    Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
