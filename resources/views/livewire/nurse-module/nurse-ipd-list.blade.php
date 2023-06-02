<div
    x-data="{
        moveout: {{ config('ipd.moveout') }},
        ward_id: @entangle('ward_id'),
        type_id: @entangle('editing.bedmove_type_id'),
        ipd: @entangle('ipd'),
        bedmoveName: 'ย้ายเตียง',
        wards: [],
        rooms: [],
        beds: [],
        errors: [],
        bedmoves: [],
        modalShow: (id) => {
            clearError()
            $wire.newMove(id)
        },
    }"
    x-init="
        modal = new Modal($refs.modal);
        lgModal = new Modal($refs.lgModal);

        clearError = () => {
            errors = [];
        }
    "
    @toast-event.window = "async (event) => {
        await modal.hide()
        $dispatch('toastify', { text: event.detail.text });
    }"

    @modal-show.window = "(e) => {
        ipd = e.detail.ipd
        wards = e.detail.wards
        modal.show()
    }"

    @lgmodal-show.window = "(e) => {
        bedmoves = e.detail.rows
        lgModal.show()
    }"
>
    <div class="lg:flex">
        <div class="flex-none w-full lg:max-w-md">
            <div wire:ignore class="dark:text-gray-200 pb-3.5 pt-4">
                <!--Select default-->
                <x-input.select data-te-select-size="lg" data-te-select-filter="true" wire:model="filter_ward_id" :label="__('หอผู้ป่วย')">
                    <option value="0">-- ทั้งหมด --</option>
                    @foreach ($wards as $ward)
                        <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                    @endforeach
                </x-input.select>
            </div>
        </div>
        <div class="flex-grow">
            <ul
                class="mb-4 flex list-none flex-row flex-wrap border-b-0 pl-0 lg:justify-end justify-center"
                id="tabs-tab3"
                role="tablist"
                data-te-nav-ref
            >
                <li role="presentation">
                    <a x-on:click="()=> { $wire.emit('load:data') }"
                        data-te-ripple-color="light"
                        class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                        id="tabs-home-tab3"
                        data-te-toggle="pill"
                        data-te-target="#tabs-newcase"
                        data-te-nav-active
                        role="button"
                        aria-controls="tabs-newcase"
                        aria-selected="true"
                    ><i class="fa-solid fa-user-plus text-[16px] mr-2 mt-1"></i> รับใหม่</a>
                </li>
                <li role="presentation">
                    <a
                        href="#tabs-recpcase"
                        class="focus:border-transparen my-2 block border-x-0 border-b-2 border-t-0 border-transparent lg:px-7 px-5 pb-3.5 pt-4 text-md font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                        id="tabs-profile-tab3"
                        data-te-toggle="pill"
                        data-te-target="#tabs-recpcase"
                        role="tab"
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
    <!--Tabs content-->
    <div>
    <div
        class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="tabs-newcase"
        role="tabpanel"
        data-te-tab-active
        aria-labelledby="tabs-newcase-tab">
        @livewire('nurse-module.ipd-newcase-list')
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
    <div class="lg:flex gap-2">
        <div class="flex-1 mt-2">
            <div class="lg:grid grid-cols-3 gap-3">

                <div>
                    <div class="relative mb-3" data-te-input-wrapper-init>
                        <input type="text"
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleFormControlInput2" placeholder="ค้นหา HN/AN" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-none">
            <div class="flex justify-center gap-2">
                <a role="button" href="{{ route('nurse.newcase') }}" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #3eb991">
                    <x-icon.user-plus class="text-gray-50"></x-icon.user-plus>
                    รับใหม่
                </a>
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #c17435">
                    <i class="fa-solid fa-user-check text-[14px] mr-2 mt-1"></i>
                    รับย้าย
                </button>
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #c13584">
                    <i class="fa-solid fa-user-check text-[14px] mr-2 mt-1"></i>
                    จำหน่าย
                </button>
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #45668e">
                    <x-icon.user-group class="text-gray-50"></x-icon.user-group>
                    ผู้ป่วย
                </button>
            </div>
        </div>
    </div>
    <div class="grid grid-flow-row gap-3 mb-4">
        @foreach($rows as $key => $item)
        @php
            $bedmove = $item->lastBed();
        @endphp
        <div
            class="lg:flex rounded-lg bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
            <div class="flex-1 mb-2 dark:text-gray-300">
                <div class="flex gap-4">
                    <div class="p-4 flex-none w-20 min-h-full rounded-lg flex items-center justify-center bg-sky-300 dark:bg-sky-800 dark:text-sky-400">
                        <div class="font-bold">{{ $bedmove->bed_name ?? 'รอ' }}</div>
                    </div>
                    <div class="col-span-4 sm:col-span-2 lg:col-span-1">
                        <div class="flex gap-2">
                            <h6 class="inline-block">AN: {{ $item->an }}</h6>
                            <h6 class="inline-block">HN: {{ $item->hn }}</h6>
                        </div>
                        <p class="w-full text-left">{{ $item->patient_name }}</p>
                    </div>
                    <div class="col-span-3 lg:col-span-1">
                        <h6>Ward</h6>
                        <p>{{ $bedmove->ward_name }}</p>
                    </div>
                    <div class="lg:col-span-1 col-span-4">
                        <h6>Doctor</h6>
                        <p>xxxxxxxxxxx</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2"></div>
            </div>
            <div class="flex-none">
                <button type="button" x-on:click="modalShow('{{ $item->id }}')"
                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    Move
                </button>
                <button type="button" wire:click="moveInfo('{{ $item->id }}')"
                    class="ml-2 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    History
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="w-full grid grid-cols-5 gap-4">
        <div>
            <div class="w-full bg-neutral-200 dark:bg-neutral-600">
                <div class="bg-primary p-0.5 text-center text-xs font-medium leading-none text-primary-100"
                    style="width: 25%">
                    25%
                </div>
            </div>
            <h4 class="text-base text-left">Doctor order 3/10</h4>
        </div>
        <div>
            <div class="w-full bg-neutral-200 dark:bg-neutral-600">
                <div class="bg-primary p-0.5 text-center text-xs font-medium leading-none text-primary-100"
                    style="width: 25%">
                    25%
                </div>
            </div>
            <h4 class="text-base text-left">Nurse note 3/10</h4>
        </div>
        <div>
            <div class="w-full bg-neutral-200 dark:bg-neutral-600">
                <div class="bg-primary p-0.5 text-center text-xs font-medium leading-none text-primary-100"
                    style="width: 25%">
                    25%
                </div>
            </div>
            <h4 class="text-base text-left">Vital sign 3/10</h4>
        </div>
        <div>
            <div class="w-full bg-neutral-200 dark:bg-neutral-600">
                <div class="bg-primary p-0.5 text-center text-xs font-medium leading-none text-primary-100"
                    style="width: 25%">
                    25%
                </div>
            </div>
            <h4 class="text-base text-left">Screenning 3/10</h4>
        </div>
        <div>
            <div class="w-full bg-neutral-200 dark:bg-neutral-600">
                <div class="bg-primary p-0.5 text-center text-xs font-medium leading-none text-primary-100"
                    style="width: 25%">
                    25%
                </div>
            </div>
            <h4 class="text-base text-left">Bed 3/10</h4>
        </div>
    </div>
    <x-nurse.ipd-bedmove-modal />

    <x-large-modal>
        <x-slot name="title">
            Bed move list
        </x-slot>
        <x-slot name="content">
            <table class="w-full dark:text-gray-300">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>สถานะ</th>
                        <th>เตียง</th>
                        <th>คำสั่ง</th>
                    </tr>
                </thead>
                <template x-for="(row, idx) in bedmoves" :key="idx">
                    <tr class="border-b">
                        <td x-text="idx + 1"></td>
                        <td x-text="row.date_for_thai">
                        </td>
                        <td x-text="row.time_for_editing">
                        </td>
                        <td x-text="row.movetype_name">
                        </td>
                        <td x-text="row.bed_id">
                        </td>
                        <td>
                            <div class="flex justify-center gap-2">
                                <x-button.edit style="background-color: #f48024">
                                </x-button.edit>
                                <x-button.delete style="background-color: #ea4c89"
                                    x-on:click="$dispatch('delete:confirm', { action: 'delete:bedmove'});"
                                >
                                </x-button.delete>
                            </div>
                        </td>
                    </tr>
                </template>
            </table>
        </x-slot>
    </x-large-modal>
</div>
