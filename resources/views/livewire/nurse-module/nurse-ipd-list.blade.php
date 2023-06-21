<div
    x-data="{
        rooms:[],
        beds:[],
        errors:[],
        tab: 0,
        loading: false,
        selectedId: 0,
        badges: {
            newcase: 0,
            movein: 0,
            stay: 0,
            discharge: 0,
        },
        ipd: {
            hn: '',
            an: ''
        },
        setTab: (idx) => {
            $dispatch('set-tab', {id: idx});
            tab = idx
        }
    }"
    x-init="
        ncModal = new Modal($refs.newCaseModal);
    "
    @set-tab="(e) =>  {
        tab = e.detail.id;
        $wire.set('tab', tab);
        setTimeout(()=> $dispatch('swal:close'), 1000);
    }"

    @ncmodal-show.window = "(e) => {
        ipd = e.detail.ipd;
        setTimeout(async ()=> {
            await $dispatch('swal:close')
            ncModal.show();
        }, 1000)
    }"

    @ncmodal-hide.window = "(e) => {
        $wire.emit('refresh:newcase');
        ncModal.hide();
    }"

    @err-message.window = "(e) => {
        errors = JSON.parse(e.detail.errors);
        console.log(errors)
    }"

    @update-newcase-count.window = "(e) => {
        badges.newcase = e.detail.count
    }"
>
    <div class="lg:flex justify-between">
        <div wire:ignore class="w-full lg:max-w-sm">
            <select
                x-on:change="() => { /* $dispatch('cat:progress') */ }"
                id="wardSelect"
                wire:model="filter_ward_id" data-te-select-init data-te-select-filter="true" >
                @foreach ($wards as $ward)
                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </select>
        </div>
        <div wire:ignore class="grow">
            <ul
                class="mb-4 flex list-none flex-row flex-wrap border-b-0 pl-0 lg:justify-end justify-center"
                id="tabs-tab3"
                role="tablist"
                data-te-nav-ref
            >
                <li role="presentation">
                    <x-button.nav
                        :tabName="__('tabs-newcase')"
                        x-on:click="() => {
                            $dispatch('set-tab', {id: 1});
                        }"
                        id="tabs-home-tab3"
                    >
                        <i class="fa-solid fa-user-plus text-[16px] mr-2 mt-1"></i> รอรับใหม่
                        <x-badge.red style="display: none" x-show="badges.newcase > 0" x-text="badges.newcase"></x-badge.red>
                    </x-button.nav>
                </li>
                <li role="presentation">
                    <x-button.nav
                        :tabName="__('tabs-recpcase')"
                        x-on:click="setTab(2)"
                        id="tabs-recpcase-tab3"
                    >
                        <i class="fa-solid fa-user-clock text-[16px] mr-2 mt-1"></i> รอรับย้าย
                    </x-button.nav>
                </li>
                <li role="presentation">
                    <x-button.nav
                        data-te-nav-active
                        :tabName="__('tabs-stay')"
                        x-on:click.prevent="setTab(3)"
                        id="tabs-stay-tab3"
                    >
                        <i class="fa-solid fa-user-shield text-[16px] mr-2 mt-1"></i> กำลังรักษา
                    </x-button.nav>
                </li>
                <li role="presentation">
                    <x-button.nav
                        :tabName="__('tabs-discharge')"
                        x-on:click="setTab(4)"
                        id="tabs-discharge-tab3"
                    >
                        <i class="fa-solid fa-user-check text-[16px] mr-2 mt-1"></i> จำหน่าย
                    </x-button.nav>
                </li>
            </ul>
        </div>
    </div>
    <div wire:ignore class="bg-gray">
        <div
            class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-newcase"
            role="tabpanel"
            aria-labelledby="tabs-newcase-tab">
            @livewire(
                'nurse-module.ipd-newcase-list', [
                    'user' => $user,
                    'ward_id' => $filter_ward_id,
                    'open' => false
                ],
                key('ipd-newcase'.$tab.$filter_ward_id)
            )
        </div>
        <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-recpcase"
            role="tabpanel"
            aria-labelledby="tabs-recpcase-tab">
            @livewire(
                'nurse-module.ipd-wait-list', [
                    'user' => $user,
                    'ward_id' => $filter_ward_id,
                    'open' => false
                ],
                key('ipd-wait'.$tab.$filter_ward_id)
            )
        </div>
        <div
            class="transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-stay"
            role="tabpanel"
            aria-labelledby="tabs-stay-tab"
            data-te-tab-active
        >
            @livewire(
            'nurse-module.ipd-stay-list', [
                'user' => $user,
                'ward_id' => $filter_ward_id,
                'open' => false
            ],
            key('ipd-stay'.$tab.$filter_ward_id)
            )
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
        wire:ignore
    >
        <div
            data-te-modal-dialog-ref
            class="pointer-events-none relative h-[calc(100%-1rem)] w-full translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-3xl">
            <div
                class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
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
                <div class="relative overflow-y-auto p-4">
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
                </div>
                <x-tw-modal.footer>
                    <x-button.secondary @click="ncModal.hide();">ปิด</x-button.secondary>
                    <x-button.primary wire:click="postNewBed">บันทึก</x-button.primary>
                </x-tw-modal.footer>
            </div>
        </div>
    </div>
</div>
