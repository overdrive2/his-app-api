<div x-data="{
    wardSelect: @entangle('wardSelected'),
    wardName: @entangle('wardName')
}">
    <div class="lg:flex gap-2">
        <div class="flex-1 mt-2">
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <!--Select default-->
                    <select data-te-select-init required wire:model="wardSelected" data-te-select-filter="true"
                        data-te-select-size="lg">
                        <option>-- ทั้งหมด --</option>
                        <option value="1">Ward1</option>
                        <option value="2">Ward2</option>
                        <option value="3">Ward3</option>
                    </select>
                    <label data-te-select-label-ref>หอผู้ป่วย</label>
                </div>
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
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #45668e">
                    <x-icon.user-group class="text-gray-50"></x-icon.user-group>
                    ผู้ป่วย
                </button>
                <a role="button" href="{{ route('nurse.newcase') }}" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #3eb991">
                    <x-icon.user-plus class="text-gray-50"></x-icon.user-plus>
                    รับใหม่
                </a>
                <button type="button" data-te-ripple-init data-te-ripple-color="light"
                    class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg"
                    style="background-color: #c13584">
                    <i class="fa-solid fa-user-check text-[14px] mr-2 mt-1"></i>
                    จำหน่าย
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-2">

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
    <div class="grid grid-flow-row gap-3 mb-4">
        <div
            class="lg:flex rounded-lg bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
            <div class="flex-1 mb-2">
                <div class="grid grid-cols-4 dark:text-gray-200">
                    <div class="col-span-4 sm:col-span-2 lg:col-span-1">
                        <div class="flex gap-2">
                            <h6 class="inline-block">AN: 660012546</h6>
                            <h6 class="inline-block">HN: 660012546</h6>
                        </div>
                        <p class="w-full">ผู้ป่วยทดสอบ</p>
                    </div>
                    <div class="col-span-3 lg:col-span-1">
                        <h6>Ward</h6>
                        <p>xxxxxxxxxxx</p>
                    </div>
                    <div class="col-span-1 lg:col-span-1">
                        <h6>Bed</h6>
                        <p>xxxxxxxxxxx</p>
                    </div>
                    <div class="lg:col-span-1 col-span-4">
                        <h6>Doctor</h6>
                        <p>xxxxxxxxxxx</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2"></div>
            </div>
            <div class="flex-none">
                <button type="button"
                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    Info
                </button>
                <button type="button"
                    class="ml-2 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-ripple-color="light">
                    Task
                </button>
            </div>
        </div>
    </div>
</div>
