<div class="relative"
    @initdata.window="(e) => {
        row = e.detail.row;
        console.log(row)
        if(row)
            show = (row.length == 0) ? false : true
        else
            show = false
    }"
    x-data="{
        row:[],
        show: false
    }"
>
    <template x-if="row">
        <x-header.h6>
            <span x-text="'AN '+ row.an ?? ''"></span>
            <span x-text="row.patient_name ?? ''"></span>
        </x-header.h6>
    </template>
    <div class="w-full dark:text-white" x-show="show">
        <x-button.border-b
            x-on:click.prevent="()=> showMovebedModal(row.id)"
            color="sky"
            icon="right-left"
            label="ย้ายเตียง"
        />
        <x-button.border-b
            x-on:click="() => showMovewardModal(row.id)"
            color="orange"
            icon="person-walking-dashed-line-arrow-right"
            label="ย้ายวอร์ด"
        />
        <x-button.border-b
            x-on:click="() => location.assign('{{ route('nurse.asm.list') }}?id='+row.id)"
            color="pink"
            icon="file-waveform"
            label="ASM"
        />
        <x-button.border-b
            color="green"
            icon="house-chimney-user"
            label="จำหน่าย"
        />
    </div>
    <div x-show="!show">
        <x-button.border-b
            color="primary"
            icon="user-plus"
            label="รับใหม่"
        />
        <x-button.border-b
            x-on:click="() => showMovewardModal(row.id)"
            color="amber"
            icon="user-clock"
            label="รับย้าย"
        />
    </div>
</div>
