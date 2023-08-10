<div
    x-data="{
        tab: @entangle('tab'),
        ward_id:@entangle('ward_id'),
        wards:@js($user->wards())
    }"
>
{{ $ward_id }}
    <div class="lg:flex justify-between">
        <div class="grow text-left">
            <x-nurse.top-menu />
        </div>
        <div wire:ignore class="text-right w-full lg:max-w-xs lg:mb-0 lg:mt-4">
            <div  class="flex-none w-auto py-1.5">
                <select x-ref="wardFilterSelect" x-model="ward_id" data-te-select-init>
                    <option value="0">-- ทุกห้อง --</option>
                    <template x-for="ward in wards">
                        <option :selected="ward.id == ward_id" :value='ward.id'
                            x-text='ward.name'></option>
                    </template>
                </select>
                <label data-te-select-label-ref >หอผู้ป่วย</label>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class="relative">
        <div wire:loading class="absolute top-1/2 left-1/2">
            <x-spinner />
            <h6 class="ml-5 mt-2 text-base text-gray-500">Loading...</h6>
        </div>
        <div wire:loading.class="opacity-25">
            @livewire(config('menu.nurse.'.$tab.'.component'), [
                'user' => $user,
                'ward_id' => $ward_id,
                'tab' => $tab
            ], key($tab.$ward_id))
        </div>
    </div>
</div>
