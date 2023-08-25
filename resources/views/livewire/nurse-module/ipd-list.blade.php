<div
    x-data="{
        wards:@js($wards),
        awards:[],
        rooms:@js($rooms),
        beds:[],
        errors:[],
        moveType:'',
        bedEditing:{
            ipd:{
                an:'',
                patient_name:''
            },
            from:'From',
            to:'To',
        },
        ward_id:@entangle('ward_id'),
        room_id:@entangle('room_id'),
        to_ward_id:@entangle('to_ward_id'),

        showActionModal: async (id) => {
            $dispatch('cat:progress')
            await $wire.edit(id)
            acModal.show()
            $dispatch('swal:close')
        },

        selectRow: async (val) => {
            await $wire.selectRow(val.bed.id)
            $store.bed.set({id: val.bed.id, name: val.bed.name, wardId: val.wardId})
            $dispatch('get-newcase');
            offCanvas.show()
        },

        move:async (type, id)=>{
            $dispatch('cat:progress')
            moveType = type
            if(type == 'bed') {
                await $wire.bedmove(id)
            }
            else if(type == 'ward') {
                await $wire.wardmove(id)
            }
            else {

            }

            $dispatch('swal:close')
            acModal.hide()
            bmModal.show()
        },

        save: async () => {
            clearError()
            $dispatch('cat:progress')
            await $wire.save()
            $dispatch('swal:close')
        }
    }"
    x-init="
        acModal = new Modal($refs.actionModal)
        bmModal = new Modal($refs.bmModal)
        bmlModal = new Modal($refs.bmlModal)

        offCanvas = new Offcanvas($refs.offCanvas)
        refreshAward = ()=>{
            $wire.awardRefresh()
        }

        clearError = () => {
            errors = [];
        }

        getNewCase = ()=> {
            $dispatch('get-newcase', { ward:ward_id })
        }
    "

    @set-rooms.window="(e)=>{ rooms = e.detail.rooms }"

    @set-bededit.window="(e)=>{
        bedEditing = e.detail.data
        if(moveType == 'bed')
            beds = e.detail.data.beds
        else if(moveType == 'ward')
            awards = e.detail.data.wards
        else
            return
    }"

    @move-success.window="()=>{
        bmModal.hide();
        $dispatch('toastify');
    }"

    @err-message.window="(e)=>{
        errors = JSON.parse(e.detail.errors);
    }"
>
    <div class="flex lg:flex-row flex-col">
        <div  class="flex-none mt-2 w-full max-w-xs" wire:ignore>
            <select x-ref="wardFilterSelect" x-model="ward_id" data-te-select-init>
                <option value="0">-- เลือกหอผู้ป่วย --</option>
                <template x-for="ward in wards">
                    <option :selected="ward.id == ward_id" :value='ward.id'
                        x-text='ward.name'></option>
                </template>
            </select>
            <label data-te-select-label-ref >หอผู้ป่วย</label>
        </div>
        <div class="grow">
            <x-nurse.top-menu />
        </div>
    </div>
    <div class="flex lg:flex-row flex-col gap-2 border-t">
        <div class="flex-none w-full max-w-xs py-1.5" wire:ignore>
            <select x-bind:disabled="ward_id == 0" x-ref="roomFilterSelect" x-model="room_id" data-te-select-init>
                <option value="0">-- ทั้งหมด --</option>
                <template x-for="room in rooms">
                    <option :selected="room.id == room_id" :value='room.id'
                        x-text='room.room_name'></option>
                </template>
            </select>
            <label data-te-select-label-ref >ห้อง</label>
        </div>
        <div class="flex-none lg:w-64 w-full py-1.5">
            <div class="mb-3">
                <input
                  type="search"
                  wire:model.debounce.600ms="search"
                  class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                  id="patientSearch"
                  placeholder="Search..." />
              </div>
        </div>
        <div class="lg:w-1/2 lg:flex grow w-auto justify-end">
            <x-button.icon class="px-3 py-1.5" @click="$store.ipdViewMode.toggle()">
                <i :class="$store.ipdViewMode.value == 'flex' ? 'text-primary-600 fa-solid fa-list' :
                    'text-neutral-500 fa-solid fa-table-cells'"
                    class=" text-xl"></i>
            </x-button.icon>
        </div>
    </div>
    <div wire:target="search" wire:loading.class="opacity-25" class="gap-2" :class="$store.ipdViewMode.value == 'flex' ? 'flex flex-col' : 'grid lg:grid-cols-3 grid-cols-1'">
        @foreach($rows as $key=>$row)
            @php
                $ipd = $row->ipd;
                $bm = $row->bedmove();
            @endphp
            <div
                wire:target="selectRow('{{ $row->id }}')"
                wire:loading.class="opacity-50"
                class="dark:text-gray-100 relative flex px-4 py-2 border rounded {{ $selectedId == $row->id ? 'border-primary' : '' }}"
                wire:key="row-{{$key}}"
            >
                <div wire:target="selectRow('{{ $row->id }}')" wire:loading wire:loading.delay.longest class="absolute left-1/2 gap-4 flex"><x-spinner /><div class="inline-block">Loading...</div></div>
                <div
                    class="grow flex gap-4">
                    <div class="flex-none w-auto">
                        @if($row->empty_flag)
                        <button
                            x-on:click.prevent="selectRow({bed: @js(['id'=>$row->id, 'name' => $row->bed_name]), wardId: ward_id})"
                            class="p-2.5 font-medium border rounded hover:bg-gray-200 h-12">{{ $row->bed_name }}</button>
                        @else
                        <div class="p-2.5 font-medium border rounded h-12">
                            <div class="h-full">{{ $row->bed_name }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="grow flex">
                        @if(!$row->empty_flag && $bm)
                        @php
                            $icon = match($bm->bedmove_type_id) {
                                1 => 'text-lg text-green-500 fa-solid fa-user-plus',
                                2 => 'text-lg text-indigo-500 fa-solid fa-person-arrow-down-to-line',
                                3 => 'text-lg text-blue-500 fas fa-compress-alt',
                                4 => 'text-lg text-amber-500 fas fas fa-people-arrows',
                                default => '',
                            }
                        @endphp
                        <div class="flex-none w-[200px] text-left">
                            <div class="font-bold text-gray-600 text-md">{{ $ipd?->patient_name }}</div>
                            <div>
                                AN: {{ $ipd?->an }}
                            </div>
                        </div>
                        <div class="flex-none text-left">
                            <div><i class="{{$icon}}"></i> {{ $bm->date_for_thai }} {{ substr($bm->movetime, 0, 5) }}</div>
                            <div>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="flex-none w-12">
                    <div class="relative" data-te-dropdown-ref>
                        <button
                            class="hover:bg-gray-500 hover:text-white border rounded-full w-7 h-7 mt-2"
                            data-te-dropdown-toggle-ref
                            aria-expanded="false"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                        >
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="absolute z-[1000] float-left m-0 py-2 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"  data-te-dropdown-menu-ref>
                            @if($row->empty_flag)
                            <li class="hover:bg-gray-200" role="button" x-on:click.prevent="selectRow({bed: @js(['id'=>$row->id, 'name' => $row->bed_name]), wardId: ward_id})">
                                <div class="px-4 py-1">
                                    <i class="fa-solid fa-user-plus text-sm mr-1"></i> รับใหม่
                                </div>
                            </li>
                            <li class="hover:bg-gray-200" role="button" x-on:click.prevent="move('bed', {{$row->id}})">
                                <div class="px-4 py-1">
                                    <i class="fa-solid fa-person-arrow-down-to-line text-sm mr-1"></i> รับย้าย
                                </div>
                            </li>
                            @else
                            <li class="hover:bg-gray-200" role="button" x-on:click.prevent="move('bed', {{$row->id}})">
                                <div class="px-4 py-1">
                                    <i class="text-sm mr-1 fas fa-people-arrows"></i> ย้ายเตียง</div>
                            </li>
                            <li class="hover:bg-gray-200" role="button" x-on:click.prevent="move('ward', row.id)">
                                <div class="px-4 py-1">
                                    <i class="text-sm mr-1 fas fa-compress-alt"></i> ย้ายวอร์ด</div>
                            </li>
                            <li class="hover:bg-gray-200" role="button" x-on:click="() => location.assign('{{ route('nurse.asm.list') }}?id='+row.id)">
                                <div class="px-4 py-1">
                                    <i class="text-md mr-1 far fa-file-alt"></i> บันทึกการพยาบาล</div>
                            </li>
                            <li class="hover:bg-gray-200" role="button">
                                <div class="px-4 py-1">
                                    <i class="text-sm mr-1 fas fa-house-user"></i> จำหน่าย</div>
                            </li>
                            @endif
                            <li class="hover:bg-gray-200"
                                role="button"
                                x-on:click="() => {
                                    bmlModal.show()
                                    $dispatch('load-bedmove')
                                }"
                            >
                                <div class="px-4 py-1">
                                    <i class="text-sm mr-1 fas fa-list"></i> ประวัติเตียง</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Action Menu modal-->
    <div wire:ignore>
        <x-tw-modal.dialog x-ref="actionModal">
            <x-slot name="title">IPD Actions Menu</x-slot>
            <x-slot name="content">
                <x-menu.ipd-action />
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary data-te-modal-dismiss>
                    Close
                </x-button.secondary>
            </x-slot>
        </x-tw-modal.dialog>
    </div>

    <!-- Bedmove List modal-->
    <div>
        <x-tw-modal.dialog
            x-ref="bmlModal"
            maxWidth="5xl"
            @load-bedmove.window="() => console.log('move list')"
        >
            <x-slot name="title">Bedmove List</x-slot>
            <x-slot name="content">
                @livewire('nurse-module.bedmove-list')
            </x-slot>
            <x-slot name="footer">
                <x-button.secondary @click="bmlModal.hide()">
                    Close
                </x-button.secondary>
            </x-slot>
        </x-tw-modal.dialog>
    </div>

    <div
        wire:ignore
    >
        <div
            x-ref="bmModal"
            data-te-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="mbModal"
            tabindex="-1"
            aria-labelledby="MoveInLabel"
            aria-hidden="true"
        >
            <div data-te-modal-dialog-ref
                class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]"
            >
                <div
                    x-data="{checkShowBedEmpty: true}"
                    class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50"
                    >
                        <!--Modal title-->
                        <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                            id="MoveInLabel" x-text="moveType == 'bed' ? 'ย้ายเตียง' : 'ย้ายวอร์ด'">
                            -
                        </h5>
                        <!--Close button-->
                        <x-button.icon @click="bmModal.hide()">
                            <x-icon.close />
                        </x-button.icon>
                    </div>
                    <!-- Error -->
                    <template x-if="errors">
                        <div class="flex flex-col gap-1">
                            <template x-for="err in errors">
                                <div x-text="err" class="text-sm text-red-500 dark:text-red-100"></div>
                            </template>
                        </div>
                    </template>
                    <!-- Content -->
                    <div class="px-4">
                        <div class="flex mb-2 font-bold text-base justify-center py-1 border-b">
                            <div x-text="'AN ' + bedEditing.ipd.an" class="px-2 w-auto"></div>
                            <div x-text="'ชื่อ-สกุล '+ bedEditing.ipd.patient_name" class="text-left px-2 w-auto"></div>
                        </div>
                        <div class="flex gap-4 mb-2">
                            <div class="grow">
                                <div class="font-bold text-primary">เตียงปัจจุบัน</div>
                                <div class="bg-primary-100 text-center w-full gap-2 border rounded-md shadow-md py-2  dark:text-white">
                                    <div class="px-2 font-bold" x-text="bedEditing.from"></div>
                                </div>
                            </div>
                            <div class="flex-none w-auto">
                                <div class="mt-8">
                                    <i class="text-primary fa-solid fa-circle-right"
                                    ></i>
                                </div>
                            </div>
                            <div class="grow">
                                <div class="font-bold text-teal-700" x-text="moveType=='bed' ? 'เตียงปลายทาง' : 'วอร์ดปลายทาง'"></div>
                                <div class="bg-teal-100 text-center w-full gap-2 border rounded-md shadow-md py-2  dark:text-white">
                                    <div class="px-2 font-bold" x-text="bedEditing.to"></div>
                                </div>
                            </div>
                        </div>
                        <div class="py-1"></div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <x-input.date wire:model.defer="editing.date_for_editing"/>
                            <x-input.tw-time id="move-time" wire:model.defer="editing.time_for_editing"/>
                        </div>
                    </div>
                    <div x-show="moveType=='bed'" class="relative overflow-y-auto p-4">
                        <x-bed-menu
                            wire:model.defer="editing.bed_id"
                        />
                    </div>
                    <div
                        x-show="moveType=='ward'"
                        class="relative overflow-y-auto w-full px-4 mb-2"
                    >
                        <div class="px-2 py-1 text-left text-sm text-gray-700">หอผู้ป่วย</div>
                        <select
                            x-ref="wardSelect"
                            x-model="to_ward_id"
                            x-on:change="()=> {
                                ward = awards.filter(x => x.id == to_ward_id)
                                bedEditing.to = ward.length > 0 ? ward[0].name : '-'
                            }"
                            data-te-select-init
                            data-te-select-filter="true"
                        >
                            <option value="0">-- เลือกหอผู้ป่วย --</option>
                            <template x-for="ward in awards">
                                <option :selected="ward.id == to_ward_id" :value='ward.id'
                                    x-text='ward.name'></option>
                            </template>
                        </select>
                    </div>
                    <x-tw-modal.footer>
                        <div class="flex-none px-2 text-left">
                            <input x-on:change="$dispatch('bedmenu-filter')" x-model="checkShowBedEmpty" type="checkbox" class="h-4 w-4">
                            <label for="checkShowBedEmpty" class="inline-block mb-1">แสดงเฉพาะเตียงว่าง</label>
                        </div>
                        <div class="grow text-right">
                            <x-button.secondary @click="bmModal.hide()">ยกเลิก</x-button.secondary>
                            <x-button.primary x-on:click="save">บันทึก</x-button.primary>
                        </div>
                    </x-tw-modal.footer>
                </div>
            </div>
        </div>
    </div>
    <div class="flex space-x-2">
        <div>
          <x-off-canvas x-ref="offCanvas">
            <div class="border-b-2 border-primary mb-4">
                <h6 class="ml-2 h-8 text-left mb-2 py-2 mt-0 text-base font-medium leading-tight text-primary">
                    <i class="fa-solid fa-user-plus text-[24px] mr-2 mt-1"></i> New case
                </h6>
            </div>
            <!-- Start Newcase List Component -->
            <div

                x-data="{
                    edit:false,
                    an: '',
                    newPost:()=>{
                        $dispatch('cat:progress')
                        $wire.save()
                    }
                }"

                @edit-newcase.window="async (e)=>{
                    await $wire.makeNewcase(e.detail.an, $store.bed.data)
                    edit = true
                    console.log($wire.editing)
                }"

                @newcase-success.window="()=>{
                    Swal.close()
                    $dispatch('toastify');
                   // $dispatch('get-newcase');
                    edit = false
                    offCanvas.hide()
                }"
            >
                <x-nurse.ipd-newcase-list />
                <div x-show="edit" class="z-50">
                    <x-input.date wire:model.defer="editing.date_for_editing" />
                    <x-input.tw-time
                        id="time_edit"
                        wire:model.defer="editing.time_for_editing"
                    />
                    <div class="flex gap-2 justify-center py-2">
                        <x-button.danger-small x-on:click="edit = false"><i class="fa-solid fa-person-circle-check"></i> ยกเลิก</x-button.danger-small>
                        <x-button.secondary-small x-on:click="newPost()"><i class="fa-solid fa-person-circle-check"></i> รับย้าย</x-button.secondary-small>
                    </div>
                </div>
            </div>
            <!-- End Newcase List Component -->
          </x-off-canvas>
        </div>
    </div>
</div>
