<div>
    <div class="lg:flex gap-2">
        <div class="flex-1">
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <!--Select default-->
                    <select data-te-select-init data-te-select-filter="true" data-te-select-size="lg">
                        <option>-- ทั้งหมด --</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                        <option value="5">Five</option>
                    </select>
                    <label data-te-select-label-ref>หอผู้ป่วย</label>
                </div>
                <div>
                    <div class="relative mb-3" data-te-input-wrapper-init>
                        <input type="text" class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[2.15] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" id="exampleFormControlInput2" placeholder="ค้นหา HN/AN" />
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-none">
            <div class="flex justify-center gap-2">
                <button type="button" data-te-ripple-init data-te-ripple-color="light" class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg" style="background-color: #45668e">
                    <x-icon.user-group class="text-gray-50"></x-icon.user-group>
                    ผู้ป่วย
                </button>
                <button type="button" data-te-ripple-init data-te-ripple-color="light" class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg" style="background-color: #3eb991">
                    <x-icon.user-plus class="text-gray-50"></x-icon.user-plus>
                    รับใหม่
                </button>
                <button type="button" data-te-ripple-init data-te-ripple-color="light" class="mb-2 flex rounded px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg" style="background-color: #c13584">
                    <i class="fa-solid fa-user-check text-[14px] mr-2 mt-1"></i>
                    จำหน่าย
                </button>
            </div>
        </div>
    </div>
</div>
