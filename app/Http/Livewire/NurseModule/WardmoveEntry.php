<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\IpdBedmove;
use App\Http\Livewire\Traits\BedmoveService;
use App\Models\Ipd;
use App\Models\Ward;
use Livewire\Component;

class WardmoveEntry extends Component
{
    use BedmoveService;

    public IpdBedmove $wm;

    protected $listeners = [
        'move:ward' => 'new'
    ];

    public function rules()
    {
        return [
            'wm.ipd_id' => 'required',
            'wm.movedate' => 'required',
            'wm.movetime' => 'required',
            'wm.created_by' => 'required',
            'wm.updated_by' => 'required',
            'wm.date_for_editing' => '',
            'wm.time_for_editing' => '',
            'wm.ward_id' => 'required',
            'wm.bed_id' => '',
            'wm.bedmove_type_id' => 'required',
            'wm.from_ref_id' => '',
            'wm.to_ref_id' => '',
            'wm.delflag' => '',
        ];
    }

    public function new($id)
    {
        $this->wm = $this->makeBlank();
        $this->wm->ipd_id = $id;
        $this->wm->from_ref_id = Ipd::where('id', $this->wm->ipd_id)->value('current_bedmove_id');

        $this->dispatchBrowserEvent('open-mw-modal', [
            'wards' => auth()->user()->wards(),
        ]);
    }

    public function mount()
    {
        $this->wm = $this->makeBlank();
    }

    public function save()
    {
        $this->wm->bedmove_type_id = config('ipd.moveout');
        $this->bedMoveValidate('wardmove-error');

        $this->wm->bed_id = Ward::find($this->wm->ward_id)->wait_bed_id;

        $this->wm->save();

        $this->dispatchBrowserEvent('close-mw-modal');
    }

    public function render()
    {
        return view('livewire.nurse-module.wardmove-entry');
    }
}
