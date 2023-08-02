<div
    {{ $attributes->merge(['class' => 'w-full']) }}
>
    <template x-if="edit === true">
        <div
            x-data="{
                editingData: Object.create(data)
            }"
            class="flex gap-1"
        >
            <div class="flex-none w-16">
                <x-input.text type="text" class="w-full text-sm" x-model="editingData.key"/>
            </div>
            <div class="grow">
                <x-input.text type="text" class="text-sm w-full" x-model="editingData.value"/>
            </div>
            <div class="text-gray-500 w-auto flex gap-1">
                <button
                    type="button"
                    x-on:click="() => {
                        data = {
                            key: editingData.key,
                            value: editingData.value,
                        }
                        opt = data
                        console.log(opt)
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
        <div class="w-full flex">
            <div class="flex-none w-16" x-text="data.key"></div>
            <div class="grow" x-text="data.value"></div>
            <div class="text-gray-500 w-auto flex gap-1">
                <button
                    x-on:click="() => {
                        current_idx = idx
                        editingData = optValues[idx]
                        edit = !edit
                    }"
                ><x-icon.pencil class="h-5 w-5"/></button>
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
</div>
