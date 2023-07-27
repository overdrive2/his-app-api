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
        editSection: (id) => {

        },
        save:() => {
            $dispatch('cat:progress')
            $wire.save();
        }
    }"

    x-init="
        edModal{{ $section_id }} = new Modal($refs.edModal{{ $section_id }})
        imp1 = new Input($refs.inp)
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
                    <x-icon.pencil-square class="w-5 h-5 inline-block text-gray-600 mb-1" /></button>
                    {{ $row->no ? $row->no : $row->display_order }} {{ $row->web_label }}
            </div>
            <div class="p-4 border">
                @switch($row->input_type)
                    @case('radio')
                        <div class="flex justify-start" x-id="['radio-input']">
                            <!--First radio-->
                            @foreach($row->json_data as $item)
                                <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                                <input
                                    class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                    type="radio"
                                    name="inlineRadioOptions"
                                    :id="$id('radio-input')"
                                    value="{{ $item->key }}" />
                                <label
                                    class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                    :for="$id('text-input')"
                                    >{{ $item->value }}</label
                                >
                                </div>
                            @endforeach
                        </div>
                        @break
                    @case('select')
                        <div wire:ignore>
                            <select data-te-select-init :id="$id('select-input')">
                                @foreach($row->json_data as $item)
                                <option value="{{$item->key}}">{{ $item->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @break
                    @case('textarea')
                        <div wire:ignore class="relative mb-3" data-te-input-wrapper-init>
                            <textarea
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            :id="$id('textarea-input')"
                            rows="3"
                            placeholder="..."></textarea>
                            <label
                            for="$id('textarea-input')"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                            >{{ $row->web_label }}</label
                            >
                        </div>
                        @break
                @endswitch
                @if($row->have_other)
                <div class="w-full text-left mt-2">
                    <label :for="$id('text-input')">Other</label>
                    <input :id="$id('text-input')" type="text" class="border rounded-md w-full px-2 focus:ring-sky-600"/>
                </div>
                @endif
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
                refItem: false,
                refType: '',
                edItem: {
                    key:'',
                    value: '',
                    ref: false
                },
                subItem: {
                    type:'',
                    label:'',
                    jsonData:'',
                },
                itmt: @entangle('editing.input_type'),
                optValues: @entangle('editing.json_data'),
            }"
            class="flex flex-col gap-2"
        >
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
                <div x-show="(itmt === 'radio')||(itmt === 'select')">
                    <div class="grid grid-cols-1 gap-2">
                        <div class="mt-2 text-left">
                            <button
                                class="px-2 py-0.5 rounded-md border bg-primary-600 text-white"
                                x-show="!newItem"
                                type="button"
                                x-on:click="() => {
                                    newItem = true;
                                    edItem = {
                                        key:'',
                                        value: '',
                                        ref: false
                                    };
                                    $nextTick(() => { $refs.itemValue.focus(); });
                                }"
                            >New Value
                            </button>
                        </div>
                        <div>
                            <div x-show="newItem == true">
                                <div class="mt-1">
                                    <div class="flex gap-1">
                                        <div class="flex gap-2 grow">
                                            <label for="itemValue">Key</label>
                                            <input x-model="edItem.key"  x-ref="itemValue" type="text" class="px-2 flex-none w-12 border rounded-sm">
                                            <label for="itemName">Value</label>
                                            <input x-model="edItem.value" x-ref="itemName" type="text" class="grow  border rounded-sm px-2">
                                            <input type="checkbox" x-model="edItem.ref" x-ref="itemRef">Ref
                                        </div>
                                        <div class="flex-none w-auto">
                                            <button
                                                type = "button"
                                                x-on:click="()=> {
                                                    idx = optValues.findIndex((obj) => obj.key == edItem.key)

                                                    newObject = edItem

                                                    if(edItem.ref == true) {
                                                        newObject = {
                                                            key:edItem.key,
                                                            value: edItem.value,
                                                            ref: true,
                                                            refOpts: [],
                                                        }
                                                    }


                                                    if(idx >= 0) {
                                                        optValues[idx] = newObject
                                                    }
                                                    else
                                                        optValues.push(newObject);

                                                    console.log(optValues)
                                                    newItem = false;
                                                }"
                                                class = "text-green-500 inline-block hover:bg-gray-300"
                                            >
                                                <x-icon.check />
                                            </button>
                                            <button type="button" class="text-red-500 hover:bg-gray-300" x-on:click="newItem=false">
                                                <x-icon.x-mark />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div x-show="refItem == true">
                                <div class="mt-1 flex gap-1">
                                    <div class="flex-none w-40 text-sm">
                                        <select
                                            x-model="subItem.type"
                                            :id="$id('select-ref')"
                                            data-te-select-init
                                        >
                                            <option value="0">-- ประเภท --</option>
                                            <template x-for="itm in inputs">
                                                <option :selected="refType === itm"  :value="itm" x-text="itm" />
                                            </template>
                                            <label data-te-select-label-ref class="z-50 bg-white">ประเภทข้อมูล</label>
                                        </select>
                                    </div>
                                    <div class="grow w-full">
                                        <!--Small input-->
                                        <div class="relative mb-3" data-te-input-wrapper-init>
                                            <input
                                                x-model="subItem.label"
                                                type="text"
                                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.33rem] text-sm leading-[1.5] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                                :id="$id('text-input')"
                                                placeholder="Label"
                                            />
                                            <label
                                            :for="$id('text-input')"
                                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] text-sm leading-[1.5] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.75rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.75rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                                            >Label
                                            </label>
                                        </div>
                                    </div>
                                    <div class="float-none w-28">
                                        <button
                                            type="button"
                                            x-on:click="()=> {
                                                data = {
                                                    type: subItem.type,
                                                    label: subItem.label
                                                }

                                                idx = optValues.findIndex((obj) => obj.key == edItem.key)

                                                if(idx >= 0){
                                                    optValues[idx].refOpts.push(data);
                                                }

                                                refItem=false;
                                                console.log(optValues[idx])
                                            }"
                                            class="text-green-500 inline-block hover:bg-gray-300"
                                        >
                                            <x-icon.check />
                                        </button>
                                        <button type="button" class="text-red-500 hover:bg-gray-300" x-on:click="refItem=false">
                                            <x-icon.x-mark />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <template x-for="opt in optValues">
                                <div class="border-b py-1">
                                    <div class="flex gap-2">
                                        <div class="grow text-left px-4" x-text="opt.key + ' : ' + opt.value"></div>
                                        <template x-if="opt.ref === true">
                                            <button type="button" x-on:click="() => {
                                                edItem = {
                                                    key: opt.key,
                                                    value: opt.value,
                                                    ref: (opt.ref === undefined) ? false : opt.ref
                                                };
                                                refItem = true;
                                            }">
                                                <x-icon.bars-arrow-down />
                                            </button>
                                        </template>
                                        <button
                                            type="button"
                                            x-on:click="() => {
                                                edItem = {
                                                    key: opt.key,
                                                    value: opt.value,
                                                    ref: (opt.ref === undefined) ? false : opt.ref
                                                };
                                                newItem = true;
                                            }"
                                            class="text-gray-500 hover:text-gray-700 rounded-md font-normal flex-none"
                                        >
                                            <x-icon.pencil class="h-5 w-5"/>
                                        </button>
                                        <button type="button" x-on:click="alert(opt)" class="text-gray-500 hover:text-gray-700 rounded-md font-normal flex-none"><x-icon.x-mark /></button>
                                    </div>
                                    <template x-if="opt.ref === true">
                                        <div class="mt-4" x-data="{
                                            refOpts: opt.refOpts
                                        }">
                                            <template x-for="opt in refOpts">
                                                <div class="relative mb-3 w-full">
                                                    <x-input.text x-bind:type="opt.type" />
                                                    <x-input.label x-text="opt.label"></x-input.label>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 mt-2">
                <x-input.tw-text label="colspan" type="number" wire:model.defer="editing.colspan" />
                <x-input.tw-text label="ลำดับ" type="number" wire:model.defer="editing.display_order" />
                <x-input.tw-text label="เลขหัวข้อ" type="text" wire:model.defer="editing.no" />
            </div>
            <div class="flex gap-2 text-left">
                <input type="checkbox" wire:model.defer="editing.have_other" /> Have Other
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <x-button.secondary data-te-modal-dismiss aria-label="Close">ยกเลิก</x-button.secondary>
        <x-button.primary x-on:click="save">บันทึก</x-button.primary>
    </x-slot>
    </x-tw-modal.dialog>
</div>
