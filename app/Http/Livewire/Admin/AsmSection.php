<?php

namespace App\Http\Livewire\Admin;

use App\Models\IpdFormSection;
use Livewire\Component;

class AsmSection extends Component
{
    public $form_id = 1;
    public $uid;
    public IpdFormSection $editing;

    protected $listeners = [
        'edit:section' => 'edit'
    ];

    public function rules()
    {
        return [
            'editing.name' => 'required',
            'editing.ipd_form_asm_id' => 'required',
            'editing.col' => '',
            'editing.parent_id' => '',
            'editing.display_order' => '',
            'editing.created_by' => '',
            'editing.updated_by' => '',
        ];
    }

    public function makeBlank()
    {
        return IpdFormSection::make([
            'ipd_form_asm_id' => $this->form_id,
            'parent_id' => 0,
            'display_order' => null,
            'updated_by' => $this->uid,
            'created_by' => $this->uid,
        ]);
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        $this->dispatchBrowserEvent('edmodal-show');
    }

    public function edit($id)
    {
        $this->editing = IpdFormSection::find($id);
        $this->dispatchBrowserEvent('edmodal-show');
    }

    public function getRowsProperty()
    {
        return IpdFormSection::where('ipd_form_asm_id', $this->form_id)->get();
    }

    public function mount()
    {
        $this->uid = auth()->user()->id;
        $this->editing = $this->makeBlank();
    }

    public function save()
    {
        $this->editing->save();
        $this->dispatchBrowserEvent('toastify', [
            'text' => 'ดำเนินการสำเร็จ'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.asm-section', [
            'rows' => $this->rows
        ]);
    }
}
