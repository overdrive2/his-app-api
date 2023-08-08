<div
    x-data="{
        tab: @entangle('tab')
    }"
>
    <div class="lg:flex justify-between">
        <div class="grow text-left">
            <x-nurse.top-menu />
        </div>
        <div wire:ignore class="text-right w-full lg:max-w-xs lg:mb-0 lg:mt-4">
            <x-input.select
                wire:model="ward_id"
                label="หอผู้ป่วย"
            >
                @foreach ($user->wards() as $ward)
                <option
                    value="{{ $ward->id }}"
                    {{ $ward->id == $ward_id ? 'selected' : '' }}
                >{{ $ward->name }}
                </option>
                @endforeach
            </x-input.select>
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
