<div
    x-data = "{
        errors: []
    }"
    @save-wardmove.window="()=>$wire.save()"

    @wardmove-error.window="(e) => {
        errors = JSON.parse(e.detail.errors);
    }"
>
    <h6 class="text-left text-base font-bold border-b mb-2">{{ __('วัน/เวลาที่ย้าย') }}</h6>
    <div class="grid grid-cols-2 gap-4 mt-4 mb-2" wire:ignore >
        <x-input.date
            label="วันที่"
            wire:model.defer="wm.date_for_editing"
        />
        <x-input.tw-time
            id="time_edit"
            label="เวลา"
            wire:model.defer="wm.time_for_editing"
        />
    </div>
    <h6 class="text-left text-base font-bold border-b py-2">{{ __('เลือกหอผู้ป่วย') }}</h6>
    <div>
        <x-ward-menu wire:model.defer="wm.ward_id" />
    </div>
    <x-error x-show="errors['wm.ward_id']"
        x-text="errors['wm.ward_id']"
    ></x-error>
</div>
