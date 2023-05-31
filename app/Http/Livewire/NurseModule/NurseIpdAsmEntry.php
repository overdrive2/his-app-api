<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\IpdFormAsm;
use App\Models\IpdFormAsmDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NurseIpdAsmEntry extends Component
{
    public $form_id = 1;
    public $ipd_id;

    public function getRowProperty()
    {
        return IpdFormAsm::find($this->form_id);
    }

    public function getGroupsProperty()
    {
        return IpdFormAsmDetail::select('group_display', 'web_label')
            ->where('ipd_form_asm_id', $this->form_id)
            ->where('input_type', 'GROUPBOX')
            ->orderBy('group_display', 'asc')
            ->get();
    }

    public function details($gid)
    {
        return IpdFormAsmDetail::where('ipd_form_asm_id', $this->form_id)
            ->where('input_type', '<>', 'GROUPBOX')
            ->where('group_display', $gid)
            ->orderBy('sub_group_display', 'asc')
            ->orderBy('display', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.nurse-module.nurse-ipd-asm-entry', [
            'form' => $this->row,
            'groups' => $this->groups
        ]);
    }
}
