<div
    x-data = "{
        wardSelect: @entangle('ward_id'),
        wards: {{ json_encode($wards) }},
        room_id: @entangle('room_id'),
        an: @entangle('an'),
        ipd: @entangle('ipd'),
        rooms: [],
        beds: [],
        editing: $wire.editing,
        modalShow: (row) => {
            $wire.new(JSON.parse(row));
            setIpd(row);
            modal.show();
        }
    }"
    x-init = "
        modal = new Modal($refs.modal);
        pname = 'Rachet';
        setIpd = (row) => {
            ipd = JSON.parse(row)
            return ipd
        }
    "
>
    <!--Verically centered scrollable modal-->
    <div class="mb-2">
        Time {{ $editing->time_for_editing }}
        <div class="max-w-xs" wire:ignore>
            <!--Select default-->
            <x-input.select wire:model="filter_ward_id" :label="__('หอผู้ป่วย')">
                <option value="0">-- ทั้งหมด --</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </x-input.select>
        </div>
    </div>
    <table class="min-w-full text-left text-sm font-light dark:text-gray-50">
        <thead class="border-b bg-white font-medium dark:border-gray-500 dark:bg-gray-600">
            <tr>
                <th scope="col" class="px-6 py-4">#</th>
                <th scope="col" class="px-6 py-4">Admit Date</th>
                <th scope="col" class="px-6 py-4">Time</th>
                <th scope="col" class="px-6 py-4">AN</th>
                <th scope="col" class="px-6 py-4">HN</th>
                <th scope="col" class="px-6 py-4">Patient name</th>
                <th scope="col" class="px-6 py-4">Age</th>
                <th scope="col" class="px-6 py-4">Ward</th>
                <th scope="col" class="px-6 py-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
                <tr
                    class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->reg_date_thai }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->regtime }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->an }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->hn }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->fullname }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ay > 0 ? $row->ay . ' ปี' : $row->am . ' เดือน' }}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">{{ $row->ward_name }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        <x-button.primary x-on:click="modalShow('{{ $row }}')">รับใหม่</x-button.primary>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="whitespace-nowrap px-6 py-4 text-center font-medium">
                        -- Empty --
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if ($rows)
        <div class="py-4">
            {{ $rows->links() }}
        </div>
    @endif
    <x-dialog-modal wire:model.defer="showEditModal" maxWidth="2xl">
        <x-slot name="title">เพิ่ม/แก้ไข</x-slot>
        <x-slot name="content">
            @livewire('nurse-module.newcase-entry', ['an' => $an], key('an' . $an . $showEditModal))
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$toggle('showEditModal')" wire:loading.attr="disabled">
                {{ __('ยกเลิก') }}
            </button>

            <x-button.primary class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal -->
    <div wire:ignore data-te-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        x-ref="modal" id="newcaseModal" tabindex="-1" aria-labelledby="newcaseModalLabel" aria-hidden="true">
        <div data-te-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
            <div
                class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                        id="newcaseModalLabel">
                        รับใหม่
                    </h5>
                    <!--Close button-->
                    <button type="button"
                        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                        data-te-modal-dismiss aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!--Modal body-->
                <div class="relative flex-auto p-4" data-te-modal-body-ref>
                    <div class="block max-w-md rounded-lg bg-white p-6 dark:bg-neutral-700">
                        <form>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-6">
                                    <div
                                        class="relative" id="timepicker-inline-24"
                                        data-te-timepicker-init
                                        data-te-input-wrapper-init
                                        data-te-format24="true"
                                        data-te-inline="true"
                                    >
                                        <input type="text"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            wire:model.defer="editing.time_for_editing"
                                            id="movetime" />
                                        <label for="movetime"
                                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">Select
                                            a time</label>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <!--First name input-->
                                <div class="relative mb-6" data-te-input-wrapper-init>
                                    <input x-model="ipd.an" type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleInput123" aria-describedby="emailHelp123" placeholder="First name" />
                                    <label for="emailHelp123"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">AN
                                    </label>
                                </div>

                                <!--Last name input-->
                                <div class="relative mb-6" data-te-input-wrapper-init>
                                    <input x-model="ipd.hn" type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="exampleInput124" aria-describedby="emailHelp124" placeholder="Last name" />
                                    <label for="exampleInput124"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">HN
                                    </label>
                                </div>
                            </div>

                            <!--Email input-->
                            <div class="relative mb-6" data-te-input-wrapper-init>
                                <input x-model="ipd.fullname" type="text"
                                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="fullname" placeholder="Email address" />
                                <label for="fullname"
                                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">ชื่อ
                                    - นามสกุล
                                </label>
                            </div>

                            <!--Ward input-->
                            <div class="relative mb-6" data-te-input-wrapper-init>
                                <input readonly x-model="$wire.ward_name" type="text"
                                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="ward_name" placeholder="หอผู้ป่วย" />
                                <label for="ward_name"
                                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">หอผู้ป่วย
                                </label>
                            </div>

                            <div class="mb-6" @rooms-update.window="(e) => { rooms = e.detail.rooms }">
                                <x-input.select :label="__('ห้อง')" wire:model="room_id">
                                    <option value="0">-- เลือกห้อง --</option>
                                    <template x-for="room in rooms">
                                        <option :value='room.id' x-text='room.room_name'>
                                        </option>
                                    </template>
                                </x-input.select>
                            </div>
                            <div class="mb-6"
                                @beds-update.window="(e) => {
                                    beds = e.detail.beds
                                }">
                                <x-input.select :label="__('เตียง')" wire:model="editing.bed_id">
                                    <option value="0">-- เลือกเตียง --</option>
                                    <template x-for="bed in beds">
                                        <option :value='bed.id' x-text='bed.bed_name'>
                                        </option>
                                    </template>
                                </x-input.select>
                            </div>
                        </form>
                    </div>
                </div>

                <!--Modal footer-->
                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                        data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Close
                    </button>
                    <button type="button" wire:click="save"
                        class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                        data-te-ripple-init data-te-ripple-color="light">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
