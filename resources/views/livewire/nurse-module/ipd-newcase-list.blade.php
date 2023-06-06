<div x-data="{
        ipds:[],
        an:'',
        dt: false,
        row: [],
        buttonDisabled: false,
    }"
    x-init="
        stepper = new Stepper($refs.stepper);
        table = $refs.table;
        setAn = async (val) => {
            buttonDisabled = true;
            let dv = document.getElementById(`row${val}`);
            dv.classList.add('animate-pulse');
            await $wire.setAn(val);
            dv.classList.remove('animate-pulse');
            an = val
            dt = true
            stepper.changeStep(0)
        }
        detailToggle = () => {
            this.dt = !this.dt
        }
    "
    @set-ipds.window="(e) => {
        ipds = e.detail.data.data;
        console.log(ipds);
    }"

    @set-ipd.window = "(e) => {
        ipd = e.detail.data;
    }"

    @err-display.window = "(e) => {
        alert(e.detail.message)
    }"
    >
    <div x-ref="table" id="list" class="grid grid-flow-row dark:text-white" :class="!dt ? '' : 'hidden'">
        <div class="flex gap-2">
            <div class="flex-none w-24">Date</div>
            <div class="flex none w-20">Time</div>
            <div class="flex-none w-20">AN</div>
            <div class="flex none w-20">HN</div>
            <div class="grow"> Full Name</div>
        </div>
        @foreach ($rows as $ipd)
            <div id="row{{$ipd->an}}" x-on:click="setAn('{{ $ipd->an }}')"
                class="flex border-b gap-2 dark:border-gray-500 dark:hover:bg-gray-700 hover:bg-gray-100" role="button" x-bind:disabled="buttonDisabled" >
                <div class="flex-none w-24">{{ $ipd->regdate }}</div>
                <div class="flex-none w-20">{{ $ipd->regtime }}</div>
                <div class="flex-none w-20">{{ $ipd->an }}</div>
                <div class="flex-none w-20">{{ $ipd->hn }}</div>
                <div class="grow text-left">{{ $ipd->pname . $ipd->fname . ' ' . $ipd->lname }}</div>
            </div>
        @endforeach
    </div>
    <div x-show="!detail">
        Nodetail
    </div>
    <div x-show="detail" id="detail" wire:ignore>
        <x-button.custom x-on:click="dt = false">Back</x-button.custom>
        <ul x-ref="stepper"
            data-te-stepper-init
            class="relative m-0 flex list-none justify-between overflow-hidden p-0 transition-[height] duration-200 ease-in-out">
            <!--First item-->
            <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
                <div data-te-stepper-head-ref
                    class="flex cursor-pointer items-center pl-2 leading-[1.3rem] no-underline after:ml-2 after:h-px after:w-full after:flex-1 after:bg-[#e0e0e0] after:content-[''] hover:bg-[#f9f9f9] focus:outline-none dark:after:bg-neutral-600 dark:hover:bg-[#3b3b3b]">
                    <span data-te-stepper-head-icon-ref
                        class="my-6 mr-2 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full bg-[#ebedef] text-sm font-medium text-[#40464f]">
                        1
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="font-medium text-neutral-500 after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300">
                        step1
                    </span>
                </div>
                <div data-te-stepper-content-ref class="absolute w-full p-4 transition-all duration-500 ease-in-out">
                    <div>
                        AN <span x-text="ipd.an"></span>
                        regdate <span x-text="ipd.regdate"></span>
                        regtime <span x-text="ipd.regtime"></span>
                    </div>
                </div>
            </li>

            <!--Second item-->
            <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
                <div data-te-stepper-head-ref
                    class="flex cursor-pointer items-center leading-[1.3rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:bg-[#e0e0e0] before:content-[''] after:ml-2 after:h-px after:w-full after:flex-1 after:bg-[#e0e0e0] after:content-[''] hover:bg-[#f9f9f9] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 dark:hover:bg-[#3b3b3b]">
                    <span data-te-stepper-head-icon-ref
                        class="my-6 mr-2 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full bg-[#ebedef] text-sm font-medium text-[#40464f]">
                        2
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="text-neutral-500 after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300">
                        step2
                    </span>
                </div>
                <div data-te-stepper-content-ref
                    class="absolute left-0 w-full translate-x-[150%] p-4 transition-all duration-500 ease-in-out">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                    nisi ut aliquip ex ea commodo consequat.
                </div>
            </li>

            <!--Third item-->
            <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
                <div data-te-stepper-head-ref
                    class="flex cursor-pointer items-center pr-2 leading-[1.3rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:bg-[#e0e0e0] before:content-[''] hover:bg-[#f9f9f9] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 dark:hover:bg-[#3b3b3b]">
                    <span data-te-stepper-head-icon-ref
                        class="my-6 mr-2 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full bg-[#ebedef] text-sm font-medium text-[#40464f]">
                        3
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="text-neutral-500 after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300">
                        step3
                    </span>
                </div>
                <div data-te-stepper-content-ref
                    class="absolute left-0 w-full translate-x-[150%] p-4 transition-all duration-500 ease-in-out">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur.
                </div>
            </li>
        </ul>
    </div>
</div>
