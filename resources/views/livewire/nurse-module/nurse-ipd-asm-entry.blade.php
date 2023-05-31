<div>
    <div class="text-left">
        <h4 class="p-4 text-lg font-bold text-gray-600 w-full border-b mb-4">
            {{ $form->asm_name }}
        </h4>
        <div class="flex flex-col gap-2">
            @foreach($groups as $group)
            <div>
                <h5 class="text-md font-normal">
                    {{ $group->group_display }}. {{ $group->web_label }}
                </h5>
                <div class="flex flex-wrap gap-2">
                    @foreach($this->details($group->group_display) as $key => $item)
                        <div class="w-full border {{ $item->width == 'lg' ? 'w-[350px]' : '' }} {{ $item->width == 'md' ? 'w-[200px]' : '' }}">
                            <input
                            type="text"
                            id="searchAnInput"
                            aria-describedby="searchAnHelp"
                            placeholder="ค้นหา AN"
                        />
                        <label for="searchAnHelp" label="{{ $item->web_label }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
