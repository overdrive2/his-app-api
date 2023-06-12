<div
    x-data="{
        rooms:[],
        beds:[],
        ipd: {
            hn: '',
            an: ''
        }
    }"
    x-init="
        ncModal = new Modal($refs.newCaseModal);
    "
    @ncmodel-show.window = "(e) => {
        ipd = e.detail.ipd;
        rooms = e.detail.rooms;
        beds = e.detail.beds;
        console.log(rooms);
        ncModal.show();
    }"
>
    <div class="lg:flex">
        <div wire:ignore class="flex-none lg:max-w-sm w-full dark:text-gray-200 pb-3.5 pt-4">
            <select wire:model="filter_ward_id" data-te-select-init data-te-select-filter="true" >
                @foreach ($wards as $ward)
                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-grow">
            <ul wire:ignore
                class="mb-4 flex list-none flex-row flex-wrap border-b-0 pl-0 lg:justify-end justify-center"
                id="tabs-tab3"
                role="tablist"
                data-te-nav-ref
            >
                <li role="presentation">
                    <a wire:click="$set('page', 1)"
                        data-te-ripple-color="light"
                        class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                        id="tabs-home-tab3"
                        data-te-toggle="pill"
                        data-te-nav-active
                        data-te-target="#tabs-newcase"
                        role="button"
                        aria-controls="tabs-newcase"
                        aria-selected="true"
                    ><i class="fa-solid fa-user-plus text-[16px] mr-2 mt-1"></i> รับใหม่</a>
                </li>
                <li role="presentation">
                    <a
                        wire:click="$set('page', 2)"
                        data-te-ripple-color="light"
                        class="focus:border-transparen my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                        id="tabs-recpcase-tab3"
                        data-te-toggle="pill"
                        data-te-target="#tabs-recpcase"
                        role="button"
                        aria-controls="tabs-recpcase"
                        aria-selected="false"
                    ><i class="fa-solid fa-user-clock text-[16px] mr-2 mt-1"></i> รับย้าย</a>
                </li>
                <li role="presentation">
                    <a
                    href="#tabs-move"
                    class="focus:border-transparen my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                    id="tabs-messages-tab3"
                    data-te-toggle="pill"
                    data-te-target="#tabs-move"
                    role="tab"
                    aria-controls="tabs-move"
                    aria-selected="false"
                    ><i class="fa-solid fa-user-shield text-[16px] mr-2 mt-1"></i> กำลังรักษา</a
                    >
                </li>
                <li role="presentation">
                    <a
                    href="#tabs-discharge"
                    class="focus:border-transparen my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                    id="tabs-messages-tab3"
                    data-te-toggle="pill"
                    data-te-target="#tabs-discharge"
                    role="tab"
                    aria-controls="tabs-discharge"
                    aria-selected="false"
                    ><i class="fa-solid fa-user-check text-[16px] mr-2 mt-1"></i> จำหน่าย</a
                    >
                </li>
            </ul>
        </div>
    </div>
    <div>
        <div
            class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-newcase"
            role="tabpanel"
            data-te-tab-active
            aria-labelledby="tabs-newcase-tab">
            @livewire(
                'nurse-module.ipd-newcase-list', [
                    'user' => $user,
                    'ward_id' => $filter_ward_id,
                    'open' => ($page == 1)
                ],
                key('ipd-newcase'.$page.$filter_ward_id)
            )
        </div>
        <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-recpcase"
            role="tabpanel"
            aria-labelledby="tabs-recpcase-tab">
            Tab 2 content button version
        </div>
        <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-move"
            role="tabpanel"
            aria-labelledby="tabs-move-tab">
            Tab 3 content button version
        </div>
        <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-discharge"
            role="tabpanel"
            aria-labelledby="tabs-discharge-tab">
            Tab 4 content button version
        </div>
    </div>
    <div
        x-ref="newCaseModal"
        data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="exampleModalXl"
        tabindex="-1"
        aria-labelledby="newcaseModalLabel"
        aria-modal="true"
        role="dialog"
    >
        <div
            data-te-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px] min-[992px]:max-w-[800px] min-[1200px]:max-w-[1140px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5
                    class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                    id="newcaseModalLabel">
                        รับเข้าเตียง
                    </h5>
                    <!--Close button-->
                    <button
                    type="button"
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-modal-dismiss
                    aria-label="Close">
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
                    <div id="ipd-card" class="text-xl font-medium dark:text-gray-200 text-gray-600">
                        <div>
                            <h6 class="inline-block">AN <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.an"></span></h6>
                            <h6 class="inline-block">HN <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.hn"></span></h6>
                        </div>
                        <div>
                            <h6>ชื่อ - นามสกุล <span class="font-bold text-gray-700 dark:text-gray-50" x-text="ipd.patient_name"></span></h6>
                        </div>
                    </div>
                    <div class="mb-4">
                        <template x-for="room in rooms">
                            <div class="max-w-xs px-2 py-2 border rounded-md bg-gray-200 dark:bg-gray-600">ห้อง <span x-text="room.room_name"></span></div>
                        </template>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="bed in beds">
                            <div role="button" x-on:click="alert(bed.bed_name)" class="px-4 py-4 border rounded-md w-full max-w-xs"><span x-text="bed.bed_name"></span></div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
