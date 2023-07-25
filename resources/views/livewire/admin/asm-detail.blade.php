<div
    x-data="{
        inputs: @js(config('input.inputs')),
        newasm:(id) => {
            $dispatch('cat:progress')
            $wire.new(id);
        },
        edit:(id) => {
            $dispatch('cat:progress')
            $wire.edit(id);
        },
        save:() => {
            $dispatch('cat:progress')
            $wire.save();
        }
    }"

    x-init="
        edModal{{ $section_id }} = new Modal($refs.edModal{{ $section_id }})
    "
    @edmodal{{ $section_id }}-show.window="() => {
        setTimeout(() => {
            $dispatch('swal:close')
            edModal{{ $section_id }}.show()
        }, 1000)
    }"

    @edmodal{{ $section_id }}-close.window="() => {
        setTimeout(() => {
            edModal{{ $section_id }}.hide()
        }, 1000)
    }"
>
    <div class="flex px-2 shadow-sm border py-1">
        <div class="grow text-left w-full text-lg font-normal text-gray-600 dark:text-gray-50">{{ $section->display_order }}. {{ $section->name }}</div>
        <div class="flex-none">
            <button type="button" x-on:click="edit('{{ $section->id }}')" class="border rounded-sm shadow-md px-1 text-sm">
                <x-icon.pencil-square class="w-5 h-5 inline-block text-gray-600" />Edit</button>
        </div>
    </div>
    <div class="text-left py-2 ml-2"><x-button.small-primary x-on:click="newasm({{$section_id}})">New</x-button.small-primary></div>
    <x-asm.parent :id="'row-'.$section->id" :column="$section->col">
        @foreach($rows as $key => $row)
        <x-asm.item :colspan="$row->colspan">
            <div class="py-1 px-2 border text-left border-b-0">
                <button type="button" x-on:click="edit('{{ $row->id }}')" class="px-1 text-sm">
                    <x-icon.pencil-square class="w-5 h-5 inline-block text-gray-600 mb-1" /></button>{{ $row->display_order }} {{ $row->web_label }}
            </div>
            <div class="p-4 border">
                @switch($row->input_type)
                    @case('radio')
                        <div class="flex justify-center">
                        <!--First radio-->
                        @foreach($row->json_data as $item)
                            <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                            <input
                                class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="radio"
                                name="inlineRadioOptions"
                                id="inlineRadio1"
                                value="option1" />
                            <label
                                class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="inlineRadio1"
                                >{{ $item->value }}</label
                            >
                            </div>
                        @endforeach
                        </div>
                        @break
                @endswitch
            </div>
        </x-asm.item>
        @endforeach
    </x-asm.parent>
    <!-- Edit Modal -->
    <x-tw-modal.dialog
        x-ref="edModal{{ $section_id }}"
        maxWidth="xl"
        wire:ignore
    >
    <x-slot name="title">Edit Modal</x-slot>
    <x-slot name="content">
        <!-- Data Control -->
        <div
            x-data="{
                newItem: false,
                itemName: '',
                itemValue: '',
                itmt: @entangle('editing.input_type'),
                optValues: @entangle('editing.json_data'),
            }"
            class="flex flex-col gap-2"
        >
            <span x-text="itmt"></span>
            <x-input.tw-text label="Name" wire:model.defer="editing.web_label"/>
            <x-input.tw-text label="report_label" wire:model.defer="editing.report_label" />
            <div>
                <select
                    x-model="itmt"
                    id="input-datatype"
                    data-te-select-init
                >
                    <option value="0">-- เลือกประเภทข้อมูล --</option>
                    <template x-for="itm in inputs">
                        <option :selected="itmt === itm"  :value="itm" x-text="itm" />
                    </template>
                    <label data-te-select-label-ref class="z-50 bg-white">ประเภทข้อมูล</label>
                </select>
                <template x-if="itmt === 'radio'">
                    <div class="grid grid-cols-1 gap-2">
                        <div class="mt-2 text-left">
                            <button
                                class="px-2 py-0.5 rounded-md border bg-primary-600 text-white"
                                x-show="!newItem"
                                type="button"
                                x-on:click="() => {
                                    newItem = true;
                                    $nextTick(() => { $refs.itemValue.focus(); });
                                }"
                            >New Value
                            </button>
                        </div>
                        <div>
                            <template x-if="newItem == true">
                                <div class="mt-1">
                                    <div class="flex gap-1">
                                        <div class="flex gap-2 grow">
                                            <label for="itemValue">Key</label>
                                            <input x-ref="itemValue" id="itemValue" type="text" class="px-2 flex-none w-24 border rounded-sm">
                                            <label for="itemName">Value</label>
                                            <input x-ref="itemName" id="itemName" type="text" class="grow  border rounded-sm px-2">
                                        </div>
                                        <div class="flex-none w-auto">
                                            <button
                                                type="button"
                                                x-on:click="()=> {
                                                    let objVal =  {
                                                        key: $refs.itemValue.value,
                                                        value: $refs.itemName.value,
                                                    };
                                                    optValues.push(objVal);
                                                    newItem = false;
                                                }"
                                                class="text-green-500 inline-block hover:bg-gray-300"
                                            >
                                                <x-icon.check />
                                            </button>
                                            <button type="button" class="text-red-500 hover:bg-gray-300" x-on:click="newItem=false">
                                                <x-icon.x-mark />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="flex flex-col gap-2">
                            <template x-for="opt in optValues">
                                <div class="flex gap-1 border-b py-1">
                                    <div class="grow text-left px-4" x-text="opt.key+' : '+opt.value"></div>
                                    <button type="button" x-on:click="alert(opt)" class="text-white bg-red-500 hover:bg-red-700 rounded-md font-normal flex-none"><x-icon.x-mark /></button>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-between gap-2 mt-2">
                <x-input.tw-text label="colspan" type="number" wire:model.defer="editing.colspan" />
                <x-input.tw-text label="ลำดับ" type="number" wire:model.defer="editing.display_order" />
            </div>
            <input type="checkbox" wire:model.defer="editing.have_other" /> Have Other
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
