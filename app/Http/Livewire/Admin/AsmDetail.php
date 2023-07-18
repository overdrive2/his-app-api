<?php

namespace App\Http\Livewire\Admin;

use App\Models\IpdFormAsmDetail;
use Livewire\Component;

class AsmDetail extends Component
{
    public $form_id = 1;
    public $uid;
    public IpdFormAsmDetail $editing;

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
            'editing.display_order' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
        ];
    }

    public function makeBlank()
    {
        return IpdFormAsmDetail::make([
            'ipd_form_asm_id' => $this->form_id,
            'updated_by' => $this->uid,
            'created_by' => $this->uid,
        ]);
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        $this->dispatchBrowserEvent('edmodal-show');
    }

    public function getRowsProperty()
    {
        return IpdFormAsmDetail::where('ipd_form_asm_id', $this->form_id)->get();
    }

    public function mount()
    {
        $this->uid = auth()->user()->id;
        $this->editing = $this->makeBlank();
    }

    public function save()
    {
        dd($this->editing);
    }

    public function render()
    {
        return view('livewire.admin.asm-detail', [
            'rows' => $this->rows
        ]);
    }
}
