<?php

namespace App\Http\Livewire\Admin;

use App\Models\IpdFormAsmDetail;
use App\Models\IpdFormSection;
use Livewire\Component;

class AsmDetail extends Component
{
    public $form_id = 1;
    public $section_id;
    //public $optValues = [];
    public $uid;
    public IpdFormAsmDetail $editing;
    public IpdFormSection $section;

    public function rules()
    {
        return [
            'editing.ipd_form_asm_id' => 'required',
            'editing.web_label' => 'required',
            'editing.report_label' => 'required',
            'editing.input_type' => 'required',
            'editing.lookup_json' => 'required',
            'editing.default_value' => 'required',
            'editing.have_other' => 'required',
            'editing.lookup_sql' => 'required',
            'editing.parent_id' => 'required',
            'editing.no' => 'required',
            'editing.display_order' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.colspan' => 'required',
            'editing.ipd_form_section_id' => 'required',
            'editing.json_data' => ''
        ];
    }

    public function makeBlank()
    {
        return IpdFormAsmDetail::make([
            'ipd_form_asm_id' => $this->form_id,
            'updated_by' => $this->uid,
            'created_by' => $this->uid,
            'input_type' => 'text',
            'colspan' => 1,
            'ipd_form_section_id' => $this->section_id,
            'have_other' => false,
            'lookup_json' => [],
            'no' => ''
        ]);
    }

    public function new($id)
    {
        $this->section_id = $id;
        $this->editing = $this->makeBlank();
        $this->dispatchBrowserEvent('edmodal'.$this->section_id.'-show');
    }

    public function edit($id)
    {
        $this->editing = IpdFormAsmDetail::find($id);
        $this->dispatchBrowserEvent('edmodal'.$this->section_id.'-show');
    }

    public function getRowsProperty()
    {
        return IpdFormAsmDetail::where('ipd_form_asm_id', $this->form_id)
            ->where('ipd_form_section_id', $this->section_id)->orderBy('display_order', 'asc')->get();
    }

    public function mount()
    {
        $this->uid = auth()->user()->id;
        $this->editing = $this->makeBlank();
    }

    public function save()
    {
        $this->editing->save();
        $this->dispatchBrowserEvent('edmodal'.$this->section_id.'-close');
        $this->dispatchBrowserEvent('toastify', [
            'text' => 'ดำเนินการสำเร็จ'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.asm-detail', [
            'rows' => $this->rows,
            'inputTypes' => config('input.inputs')
        ]);
    }
}
