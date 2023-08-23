<div
    x-data="{
        open: false,
        loading: false,
        data: []
    }"

    x-init="
        new Button($refs.smButton);
    "

    @get-newcase.window="async () => {
        loading = true
        let res = await axios.get('/ipd/newcase/'+ $store.bed.data.wardId);
        data = res.data;
        loading = false
    }"
    x-show="!edit"
>
    <div x-show="loading">Loading...</div>
    <div
        class="flex flex-col"
    >
        <div class="py-2">
            <template x-for="item in data ">
                <div class="flex border-b py-1 px-1.5 text-sm gap-2">
                    <div class="flex-none w-auto">
                        <button
                            x-on:click="()=> $dispatch('edit-newcase', {an: item.an})"
                            type="button"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            class="h-7 flex-none inline-block rounded bg-primary px-1.5 uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <i class="text-md fa-solid fa-circle-arrow-left"></i>
                        </button>
                    </div>
                    <div class="grow flex flex-col gap-1">
                        <div class="flex">
                            <div class="grow text-left inline-block" x-text="item.fullname"></div>
                            <div class="flex-none w-auto" x-text="'AN '+ item.an"></div>
                        </div>
                        <div class="flex">
                            <div class="grow text-left" x-text="'อายุ '+ item.ay + ' ปี'"></div>
                            <div class="flex-none w-auto" x-text="'D:'+ item.regdate +' T:'+ item.regtime.substr(0, 5)"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
