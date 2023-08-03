<template x-if="opt.ref === true">
    <template x-for="(refOpt, x) in opt.refOpts">
        <div
            x-data="{
                edOpt: false,
                optIdx: null,
                optJson: {
                    key:'',
                    value:''
                },
            }"
            class="w-full"
        >
            <div class="flex gap-2 ml-4 border-t">
                <div class="flex-none w-8">
                    <span x-text="refOpt.key"></span>
                </div>
                <div class="grow flex">
                    <div x-text="'type :' + refOpt.type" class="px-2"></div>
                    <div x-text="'Label :' + refOpt.label" class="px-2"></div>
                </div>
                <div class="flex-none w-auto text-sm gap-2">
                    <template x-if="(refOpt.type=='radio' || refOpt.type=='select')">
                        <button
                            x-on:click="() => {
                                optIdx = x
                                edOpt = true
                                $nextTick(() => { $refs.optJsonKey.focus(); });
                            }"
                        >
                            <x-icon.bars-arrow-down />
                        </button>
                    </template>
                    <button
                    type="button"
                    class="text-gray-500 hover:text-gray-700 rounded-md font-normal flex-none"
                    x-on:click="() => {
                        sub_idx = x
                        subData = {
                            key:refOpt.key,
                            type:refOpt.type,
                            label:refOpt.label,
                            jsonData:refOpt.jsonData ?? {},
                        }
                        edSub = true
                    }"
                >
                    <x-icon.pencil-square class="h-5 w-5"/>
                </button>
                    <button
                        x-on:click="()=>{
                            refOpts = opt.refOpts.filter(x => x.key !== refOpt.key)
                            optValues[idx].refOpts = refOpts
                        }"
                        type="button"
                        class="text-gray-500 hover:text-gray-700 rounded-md font-normal"
                    >
                        <x-icon.trash />
                    </button>
                </div>
            </div>
            <template x-if="edOpt == true">
                <div class="flex gap-1">
                    <div class="grow flex ml-8">
                        <div class="flex-none w-16">
                            <x-input.text x-ref="optJsonKey" type="text" class="w-full text-sm" x-model="optJson.key"/>
                        </div>
                        <div class="grow">
                            <x-input.text type="text" class="text-sm w-full" x-model="optJson.value"/>
                        </div>
                    </div>
                    <div class="flex-none w-auto">
                        <button
                            type="button"
                            x-on:click="()=>{
                                jsData = {
                                    key:optJson.key,
                                    value:optJson.value
                                }
                               if(optValues[idx].refOpts[optIdx].jsonData == '')
                                    optValues[idx].refOpts[optIdx].jsonData = [];

                                optValues[idx].refOpts[optIdx].jsonData.push(jsData);
                                edOpt = false
                            }"
                        >
                            <x-icon.check />
                        </button>
                        <button type="button" x-on:click="edOpt = false"><x-icon.x-mark /></button>
                    </div>
                </div>
            </template>
            <div x-show="refOpt.jsonData != ''">
                <template x-for="optn in refOpt.jsonData">
                    <div class="flex">
                        <div class="grow px-2 text-left ml-12" x-text="optn.key + ' : ' + optn.value"></div>
                        <button
                            type="button"
                            class="flex-none w-auto"
                            x-on:click="()=>{
                                jsData = optValues[idx].refOpts[x].jsonData.filter(k => k.key !== optn.key)
                                optValues[idx].refOpts[x].jsonData = jsData
                            }"
                        >
                            <x-icon.trash />
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </template>
</template>
