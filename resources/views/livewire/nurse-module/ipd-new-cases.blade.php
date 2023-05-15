<div x-data="{
        wardSelect: @entangle('ward_id'),
        wards: {{ json_encode($wards) }},
        an: @entangle('an'),
        ipd: @entangle('ipd'),
        editing: $wire.editing,
        modalShow: (row) => {
            $wire.new();
            setIpd(row);
            modal.show();
        }
    }" x-init="
        modal = new Modal($refs.modal);
        pname = 'Rachet';
        setIpd = (row) => {
            ipd = JSON.parse(row)
            return ipd
        }
    ">
    <!--Verically centered scrollable modal-->
    <div class="mb-2">
        <div
            class="max-w-xs"
            wire:ignore
        >
            <!--Select default-->
            <x-input.select wire:model="ward_id" :label="__('หอผู้ป่วย')">
                <option value="0">-- ทั้งหมด --</option>
                @foreach($wards as $ward)
                <option value="{{$ward->id}}">{{$ward->name}}</option>
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
                <th scope="col" class="px-6 py-4">Ward</th>
                <th scope="col" class="px-6 py-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $key => $row)
            <tr class="border-b {{ $key % 2 == 0 ? 'bg-gray-100 dark:border-gray-500 dark:bg-gray-700' : 'bg-white dark:border-gray-500 dark:bg-gray-600' }}">
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $key + 1 }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->reg_date_thai }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->regtime }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->an }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->hn }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $row->fullname }}</td>
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
            @livewire('nurse-module.newcase-entry', ['an'=> $an], key('an'.$an.$showEditModal))
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
    <div wire:ignore data-te-modal-init class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none" x-ref="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div data-te-modal-dialog-ref class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]">
            <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <!--Modal title-->
                    <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200" id="exampleModalLabel">
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
                <div class="relative flex-auto p-4" data-te-modal-body-ref>
                    <div class="block max-w-md rounded-lg bg-white p-6 dark:bg-neutral-700">
                        <form>
                            <div class="grid grid-cols-2 gap-4">
                                <!--First name input-->
                                <div class="relative mb-6" data-te-input-wrapper-init>
                                    <input x-model="ipd.an" type="text" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="exampleInput123" aria-describedby="emailHelp123" placeholder="First name" />
                                    <label for="emailHelp123" class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">AN
                                    </label>
                                </div>

                                <!--Last name input-->
                                <div class="relative mb-6" data-te-input-wrapper-init>
                                    <input x-model="ipd.hn" type="text" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="exampleInput124" aria-describedby="emailHelp124" placeholder="Last name" />
                                    <label for="exampleInput124" class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">HN
                                    </label>
                                </div>
                            </div>

                            <!--Email input-->
                            <div class="relative mb-6" data-te-input-wrapper-init>
                                <input x-model="ipd.fullname" type="text" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="fullname" placeholder="Email address" />
                                <label for="fullname" class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">ชื่อ - นามสกุล
                                </label>
                            </div>

                            <div class="mb-6">
                                <x-input.select wire:model="editing.bed_id" :label="__('หอผู้ป่วย')">
                                    <option value="0">-- ทั้งหมด --</option>
                                    @foreach($wards as $ward)
                                    <option value="{{$ward->id}}">{{$ward->name}}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                            <div class="mb-6">
                                <x-input.select wire:model="editing.bed_id" :label="__('หอผู้ป่วย')">
                                    <option value="0">-- ทั้งหมด --</option>
                                    @foreach($wards as $ward)
                                    <option value="{{$ward->id}}">{{$ward->name}}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                            <!--Subscribe newsletter checkbox-->
                            <div class="mb-6 flex min-h-[1.5rem] items-center justify-center pl-[1.5rem]">
                                <input class="relative float-left -ml-[1.5rem] mr-[6px] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary" type="checkbox" value="" id="exampleCheck25" />
                                <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="exampleCheck25">
                                    Subscribe to our newsletter
                                </label>
                            </div>
                        </form>
                    </div>
                </div>

                <!--Modal footer-->
                <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                    <button type="button" class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200" data-te-modal-dismiss data-te-ripple-init data-te-ripple-color="light">
                        Close
                    </button>
                    <button type="button" wire:click="save" class="ml-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]" data-te-ripple-init data-te-ripple-color="light">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
