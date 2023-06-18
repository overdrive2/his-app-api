<div class="relative p-4" @initdata.window="(e) => row = e.detail.row"  x-data="{row:[]}">
    <x-header.h6>
        <span x-text="'AN '+ row.an"></span>
        <span x-text="row.patient_name"></span>
    </x-header.h6>
    <div class="w-full dark:text-white">
        <x-button.border-b
            color="sky"
            icon="right-left"
            label="ย้ายเตียง"
        />
        <x-button.border-b
            color="orange"
            icon="person-walking-dashed-line-arrow-right"
            label="ย้ายวอร์ด"
        />
        <x-button.border-b
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
</div>
