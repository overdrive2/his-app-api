<div
    x-data="{
        tab: @entangle('tab')
    }"
>
    <div class="lg:flex justify-between">
        <div wire:ignore class="w-full lg:max-w-sm lg:mb-0 mb-4">
            <select
                x-on:change="() => { /* $dispatch('cat:progress') */ }"
                id="wardSelect"
                wire:model="filter_ward_id" data-te-select-init data-te-select-filter="true" >
                @foreach ($wards as $ward)
                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grow">
            <ul class="mb-4 flex list-none flex-row flex-wrap border-b-0 pl-0 lg:justify-end justify-center">
                <li role="presentation">
                    <button wire:loading.attr="disabled" @click="tab=1" type="button" class="lg:px-7 px-2 pt-4 pb-3.5 text-md hover:bg-neutral-100" :class="tab == 1 ? 'border-primary-600 border-b-2 text-primary-600' : 'text-neutral-600'"><i class="fa-solid fa-user-plus text-[16px] mr-2 mt-1"></i> รอรับใหม่</button>
                </li>
                <li>
                    <button wire:loading.attr="disabled" @click="tab=2" type="button" class="lg:px-7 px-2 pt-4 pb-3.5 text-md hover:bg-neutral-100" :class="tab == 2 ? 'border-primary-600 border-b-2 text-primary-600' : 'text-neutral-600'"><i class="fa-solid fa-user-clock text-[16px] mr-2 mt-1"></i> รอรับย้าย</button>
                </li>
                <li>
                    <button wire:loading.attr="disabled" @click="tab=3" type="button" class="lg:px-7 px-2 pt-4 pb-3.5 text-md hover:bg-neutral-100" :class="tab == 3 ? 'border-primary-600 border-b-2 text-primary-600' : 'text-neutral-600'"><i class="fa-solid fa-user-shield text-[16px] mr-2 mt-1"></i> กำลังรักษา</button>
                </li>
                <li>
                    <button wire:loading.attr="disabled" @click="tab=4" type="button" class="lg:px-7 px-2 pt-4 pb-3.5 text-md hover:bg-neutral-100" :class="tab == 4 ? 'border-primary-600 border-b-2 text-primary-600' : 'text-neutral-600'"><i class="fa-solid fa-user-check text-[16px] mr-2 mt-1"></i> จำหน่าย</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- content -->
    <div class="relative">
        <div wire:loading class="absolute top-1/2 left-1/2">
            <x-spinner />
            <h6 class="ml-5 mt-2 text-base text-gray-500">Loading...</h6>
        </div>
        <div wire:loading.class="opacity-25">
            <div x-show="tab == 1">
                @livewire(
                    'nurse-module.ipd-newcase-list', [
                        'user' => $user,
                        'ward_id' => $filter_ward_id,
                        'open' => ($tab == 1)
                    ],
                    key('ipd-newcase'.($tab == 1 ? 'open' : '').$filter_ward_id)
                )
            </div>
            <div x-show="tab == 2">
                @livewire(
                    'nurse-module.ipd-wait-list', [
                        'user' => $user,
                        'ward_id' => $filter_ward_id,
                        'open' => ($tab == 2)
                    ],
                    key('ipd-wait'.($tab == 2 ? 'open' : '').$filter_ward_id)
                )
            </div>
            <div x-show="tab == 3">
                @livewire(
                    'nurse-module.ipd-stay-list', [
                        'user' => $user,
                        'ward_id' => $filter_ward_id,
                        'open' => ($tab == 3)
                    ],
                    key('ipd-stay'.($tab == 3).$filter_ward_id)
                )
            </div>
            <div x-show="tab == 4">
                Discharge
            </div>
        </div>
    </div>
</div>
