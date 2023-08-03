<div
    {{ $attributes->merge(['class' => 'w-full border-b py-1']) }}
    x-data="{
        data: {},
        idx: idx,
        sub_idx: null,
        edit: false,
        edSub: false,
        subData: {
            key:'',
            type:'text',
            value:'',
        }
    }"
>
    <template x-if="edit === true">
        <div
            class="flex gap-1"
        >
            <div class="flex-none w-16">
                <x-input.text type="text" class="w-full text-sm" x-model="data.key"/>
            </div>
            <div class="grow">
                <x-input.text type="text" class="text-sm w-full" x-model="data.value"/>
            </div>
            <div class="flex-none w-auto"><input type="checkbox" x-model="data.ref"> Ref</div>
            <div class="text-gray-500 w-auto flex gap-1">
                <button
                    type="button"
                    x-on:click="() => {
                        edData = {
                            key: data.key, ref: data.ref, value: data.value, refOpts: []
                        }
                        optValues[idx] = edData
                        edit = false
                    }"
                >
                    <x-icon.check />
                </button>
                <button type="button" x-on:click="edit = false"><x-icon.x-mark /></button>
            </div>
        </div>
    </template>
    <template x-if="!edit">
        <div class="w-full flex gap-2">
            <div class="flex-none w-12" x-text="opt.key"></div>
            <div class="grow text-left" x-text="opt.value"></div>
            <div class="text-gray-500 w-auto flex gap-1">
                <template x-if="(opt.ref === true)">
                    <button type="button" x-on:click="() => {
                        subData = {
                            key:'',
                            type:'text',
                            label:'',
                            jsonData:'',
                        };
                        sub_idx = null;
                        edSub = true;
                    }">
                        <x-icon.bars-arrow-down />
                    </button>
                </template>
                <button
                    class="hover:text-gray-600 px-1"
                    x-on:click="() => {
                        data = Object.create(opt)
                        edit = !edit
                    }"
                ><x-icon.pencil-square class="h-5 w-5"/></button>
                <button
                    type="button"
                    x-on:click="()=> {
                        optValues = optValues.filter(x => x.key !== optValues[idx].key)
                    }"
                    class="text-gray-500 hover:text-gray-700 rounded-md font-normal flex-none">
                    <x-icon.trash />
                </button>
            </div>
        </div>
    </template>
    <!-- Have ref data -->
    <template x-if="edSub">
        <div class="w-full flex gap-2 ml-4 py-1">
            <div class="flex-none w-16">
                <x-input.text type="text" class="w-full text-sm" x-model="subData.key"/>
            </div>
            <div
                class="flex-none w-24 text-sm"
                x-data
                x-init="new Select($refs.typeSelect)"
            >
                <select
                    x-ref="typeSelect"
                    x-model="subData.type"
                    :id="$id('input-select')"
                >
                    <option value="0">-- Type --</option>
                    <template x-for="itm in inputs">
                        <option :selected="subData.type === itm"  :value="itm" x-text="itm" />
                    </template>
                </select>
            </div>
            <div class="grow">
                <x-input.text type="text" class="text-sm w-full" x-model="subData.label"/>
            </div>
            <div class="text-gray-500 w-auto flex gap-1 px-2">
                <button
                    type="button"
                    x-on:click="() => {
                        if(sub_idx != null)
                            optValues[idx].refOpts[sub_idx] = {
                                key: subData.key,
                                type: subData.type,
                                label: subData.label,
                                jsonData: subData.jsonData
                            }
                        else
                            optValues[idx].refOpts.push(subData);
                        edSub = false
                    }"
                >
                    <x-icon.check />
                </button>
                <button type="button" x-on:click="edSub = false">
                    <x-icon.x-mark />
                </button>
            </div>
        </div>
    </template>
    <!-- Load from 'refOpts' (namespace only) -->
    <x-asm.sub-row />
</div>
