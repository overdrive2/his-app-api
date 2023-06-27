<div>
    <div class="text-left dark:text-gray-200">
        <h4 class="p-4 text-lg font-bold text-gray-600 dark:text-gray-200 w-full border-b mb-4">
            {{ $form->asm_name }}
        </h4>
        <div class="flex flex-col gap-2">
            @foreach($groups as $group)
            <div class="rounded-md border p-4">
                <h5 class="text-md py-4 font-bold mb-2 border-b border-primary-500 dark:border-primary-200">
                    {{ $group->display_order }}. {{ $group->web_label }}
                </h5>
                <div class="">
                    @foreach($group->asm_detail as $key => $item)
                        <div class="mb-3">{{ $item->display_order }}.  {{ $item->web_label }}</div>
                        @switch($item->input_type)
                            @case('RADIO')
                                <div class="flex justify-start mb-3" wire:loading.class="opacity-75">
                                    <!--First radio-->
                                    @foreach(json_decode($item->lookup_json ?? "[]") as $opt)
                                    <div class="mb-[0.125rem] mr-4 inline-block min-h-[1.5rem] pl-[1.5rem]">
                                    <input
                                        class="relative float-left -ml-[1.5rem] mr-1 mt-0.5 h-5 w-5 appearance-none rounded-full border-2 border-solid border-neutral-300 before:pointer-events-none before:absolute before:h-4 before:w-4 before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] after:absolute after:z-[1] after:block after:h-4 after:w-4 after:rounded-full after:content-[''] checked:border-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:left-1/2 checked:after:top-1/2 checked:after:h-[0.625rem] checked:after:w-[0.625rem] checked:after:rounded-full checked:after:border-primary checked:after:bg-primary checked:after:content-[''] checked:after:[transform:translate(-50%,-50%)] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:outline-none focus:ring-0 focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:border-primary checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] dark:border-neutral-600 dark:checked:border-primary dark:checked:after:border-primary dark:checked:after:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:border-primary dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                        type="radio"
                                        wire:model.lazy="editing.{{$item->id}}"
                                        name="inlineRadioOptions"
                                        id="radio{{$item->id}}"
                                        value="{{ $opt->id }}"
                                        wire:loading.attr="disabled"
                                        />
                                    <label
                                        class="mt-px inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="radio{{$item->id}}"
                                        >{{ $opt->text }}</label
                                    >
                                    </div>
                                    @endforeach
                                    @if($item->have_other)
                                    <div class="relative" data-te-input-wrapper-init>
                                        <input type="text"
                                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                            id="editingAnInput" aria-describedby="editingAn" placeholder="AN" />
                                    </div>
                                    @endif
                                </div>
                                @break
                            @case('DROPDOWN')
                                <div
                                    class="relative mb-3"
                                >

                                    <select class="rounded cursor-pointer bg-transparent outline-none border border-neutral-300 w-full py-[0.32rem] px-3 leading-[1.6]" wire:model="editing.{{$item->id}}">
                                        @foreach(json_decode($item->lookup_json ?? '[]') as $opt)
                                        <option value="{{$opt->id}}">{{ $opt->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @break
                            @case('MEMO')
                                <div class="relative mb-3" data-te-input-wrapper-init>
                                    <textarea
                                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="exampleFormControlTextarea1"
                                    rows="3"
                                    placeholder=""></textarea>
                              </div>
                              @break
                            @default
                                <div class="relative mb-4" data-te-input-wrapper-init>
                                    <input x-model="ipd.an" type="text"
                                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                        id="editingAnInput" aria-describedby="editingAn" placeholder="AN" />
                                    <label for="editingAn"
                                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                                        {{ $item->web_label }}
                                    </label>
                                </div>
                        @endswitch
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
