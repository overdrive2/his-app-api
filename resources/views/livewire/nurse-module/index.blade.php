<div
    x-data="{
        tab: @entangle('tab'),
        ward_id:@entangle('ward_id'),
        wards:@js($user->wards())
    }"
    x-init="new Datepicker($refs.myDatepicker)"
>
<div wire:ignore class="flex items-center justify-center">
    <div
      x-ref="myDatepicker"
      class="relative mb-3 xl:w-96"
      data-te-input-wrapper-init>
      <input
        type="text"
        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-gray-200 dark:placeholder:text-gray-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
        placeholder="Select a date" />
      <label
        for="floatingInput"
        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[2.15] text-gray-500 transition-all duration-200 ease-out peer-focus:-translate-y-[1.15rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[1.15rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-gray-200 dark:peer-focus:text-gray-200"
        >Select a date</label
      >
    </div>
  </div>
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
