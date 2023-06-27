<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Ipd;
use App\Models\IpdAsm;
use App\Models\IpdNurseShift;
use Illuminate\Validation\Validator;
use Livewire\Component;

class IpdAsmList extends Component
{
    use DateTimeHelpers;

    public $ipd_id;
    public $ipd;
    public $ipd_asm_form_id = 1;
    public $nurse_shifs;

    protected $queryString = [
        'ipd_id' => ['except' => '', 'as'=> 'id']
    ];

    public $listeners = [
        'self:refresh' => '$refresh',
    ];

    public IpdAsm $editing;

    public function new()
    {
        $this->editing = $this->makeBlank();
        $this->dispatchBrowserEvent('asm-modal-show');
    }

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.asm_date' => 'required',
            'editing.asm_time' => 'required',
            'editing.ipd_asm_form_id' => 'required',
            'editing.ipd_nurse_shift_id' => 'required',
            'editing.date_for_editing' => '',
            'editing.time_for_editing' => '',
            'editing.created_by' => 'required',
            'editing.updated_by' => 'required',
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;

        return IpdAsm::make([
            'ipd_id' => $this->ipd_id,
            'asm_date' => $this->getCurrentDate(),
            'asm_time' => $this->getCurrentTime(),
            'ipd_asm_form_id' => $this->ipd_asm_form_id,
            'ipd_nurse_shift_id' => null,
            'created_by' => $uid,
            'updated_by' => $uid,
        ]);
    }

    public function save()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $saved = $this->editing->save();
        if($saved) {
            $this->dispatchBrowserEvent('toastify', [
                'text' => 'ดำเนินการสำเร็จ'
            ]);
            $this->dispatchBrowserEvent('asm-modal-hide');
            $this->emit('self:refresh');
        }
    }

    public function mount()
    {
        $this->ipd = Ipd::find($this->ipd_id);
        $this->nurse_shifs = json_decode(IpdNurseShift::orderBy('display_order', 'asc')->get());
        $this->editing = $this->makeBlank();
    }

    public function delete($id)
    {
        IpdAsm::find($id)->delete();
    }

    public function getRowsProperty()
    {
        return IpdAsm::where('ipd_id', $this->ipd_id)->orderBy('asm_date', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-asm-list', [
            'rows' => $this->rows
        ]);
    }
}
