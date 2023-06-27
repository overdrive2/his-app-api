<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\IpdAsm;
use App\Models\IpdAsmDetail;
use App\Models\IpdFormAsm;
use App\Models\IpdFormAsmDetail;
use Livewire\Component;

class NurseIpdAsmEntry extends Component
{
    public $master_id;
    public $form_id = 1;
    public $ipd_id;
    public $editing = [];
    public IpdAsm $master;

    protected $queryString = [
        'master_id' => ['except' => '', 'as'=> 'id']
    ];

    public function rules()
    {
        return [
            'editing.*' => ''
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;

        return IpdAsm::make([
            'ipd_id' => $this->ipd_id,
            'asm_date' => $this->getCurrentDate(),
            'asm_time' => $this->getCurrentTime(),
            'ipd_asm_from_id' => $this->form_id,
            'ipd_nurse_shif_id' => null,
            'created_by' => $uid,
            'updated_by' => $uid
        ]);
    }

    public function getRowProperty()
    {
        return IpdFormAsm::find($this->form_id);
    }

    public function updatedEditing($value, $name)
    {
        IpdAsmDetail::updateOrCreate(
            ['ipd_asm_id' => $this->master->id, 'ipd_form_asm_detail_id' => $name],
            ['asm_value' => $value]
        );
    }

    public function getGroupsProperty()
    {
        return IpdFormAsmDetail::where('input_type', 'PARENT')
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function details($gid)
    {
        return IpdFormAsmDetail::where('ipd_form_asm_id', $this->form_id)
            ->where('input_type', '<>', 'GROUPBOX')
            ->where('group_display', $gid)
            ->orderBy('sub_group_display', 'asc')
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function mount()
    {
        $this->master = IpdAsm::find($this->master_id);
        $this->form_id = $this->master->ipd_asm_form_id;
        $asmds = IpdFormAsmDetail::where('ipd_form_asm_id', $this->form_id)
            ->where('input_type', '<>', 'GROUPBOX')
            ->orderBy('sub_group_display', 'asc')
            ->orderBy('display_order', 'asc')
            ->get();
            foreach ($asmds as $item) {

                $this->editing[$item->id] = IpdAsmDetail::where('ipd_asm_id', $this->master->id)->where('ipd_form_asm_detail_id', $item->id)->value('asm_value');

                if($item->default_value) { // Set Default Value
                    if(IpdAsmDetail::where('ipd_asm_id', $this->master->id)->where('ipd_form_asm_detail_id', $item->id)->count() == 0)
                        IpdAsmDetail::create([
                            'ipd_asm_id' => $this->master->id,
                            'ipd_form_asm_detail_id' => $item->id,
                            'asm_value' => $item->default_value
                        ]);
                }
            }
           // dd($this->editing);
    }

    public function render()
    {
        return view('livewire.nurse-module.nurse-ipd-asm-entry', [
            'form' => $this->row,
            'groups' => $this->groups
        ]);
    }
}
