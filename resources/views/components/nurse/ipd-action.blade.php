<div
    class="relative"
    @set-acmodal.window="(e) => {
        row = e.detail.row;
        show = (!row.ipd) ? false : true
    }"
    x-data="{
        row:[],
        show: false,
        move:async (type, id)=>{
            $dispatch('cat:progress')

            if(type == 'bed') {
                moveType = 'ย้ายเตียง'
                await $wire.bedmove(id)
            }
            else if(type == 'ward') {
                moveType = 'ย้ายวอร์ด'
                await $wire.wardmove(id)
            }
            else {

            }
            $dispatch('swal:close')
            acModal.hide()
            bmModal.show()
        },
    }"
>
    <template x-if="row.ipd">
        <x-header.h6>
            <span x-text="'AN '+ row.ipd.an ?? ''"></span>
            <span x-text="row.ipd.patient_name ?? ''"></span>
        </x-header.h6>
    </template>
    <div class="w-full dark:text-white" x-show="show">
        <x-button.border-b
            x-on:click.prevent="move('bed', row.id)"
            color="sky"
            icon="right-left"
            label="ย้ายเตียง"
        />
        <x-button.border-b
            x-on:click.prevent="move('ward', row.id)"
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
