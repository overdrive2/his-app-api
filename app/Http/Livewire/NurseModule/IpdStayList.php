<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\Ipd;
use App\Models\Ward;
use App\Services\BedmoveService;
use Livewire\Component;

class IpdStayList extends Component
{
    public $open = false;
    public $ward_id;
    public $ward;
    public $rooms = [];
    public $beds = [];
    public $ipd_id;
    public $bm = ['bed_id' => 0];
    public $wm;

    protected $listeners = [
        'load:stay' => 'loadStay',
        'stay:set:ward' => 'setWard',
        'move:bed:modal' => 'moveBedModal'
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
            'wm.delflag' => ''
        ];
    }

    public function setWard($id)
    {
        $this->ward_id = $id;
        $this->loadData();

    }

    public function moveBedModal($id)
    {
        $this->ipd_id = $id;
        $this->bm['bed_id'] = 0;
        $this->dispatchBrowserEvent('open-mb-modal', [
            'beds' => $this->beds
        ]);
    }

    public function moveWardModal($id)
    {
        $this->emit('move:ward', $id);
    }

    public function loadStay($val)
    {
        $this->open = $val;
        $this->loadData();
    }

    public function postBebmove()
    {
        $ipd = Ipd::find($this->ipd_id);
        $bedmove = (new BedmoveService)->create();
        $bedmove->ward_id = $this->ward_id;
        $bedmove->ipd_id = $ipd->id;
        $bedmove->from_ref_id = $ipd->current_bedmove_id;
        $bedmove->bedmove_type_id = config('ipd.moveself');
        $bedmove->bed_id = $this->bm['bed_id'];

        if($bedmove->bed_id == 0)
            return $this->dispatchBrowserEvent('bd-err-message', [
                'errors' => ['bedmove' => 'โปรดระบุเตียง..!']
            ]);

        $bedmove->save();
        $this->bm['bed_id'] = 0;
        $this->dispatchBrowserEvent('close-mb-modal');

    }

    public function mount()
    {
        $this->loadData();
        $this->wm = (new BedmoveService)->create();
    }

    public function loadData()
    {
        $this->ward = Ward::find($this->ward_id);
        $this->rooms = $this->ward ? $this->ward->rooms() : [];
        $this->beds = count($this->rooms) > 0 ? $this->rooms[0]->beds() : [];
        $this->dispatchBrowserEvent('set-staydata', [
            'ward' => $this->ward,
            'rooms' => $this->rooms,
            'beds' => $this->beds
        ]);
    }

    public function getRowsProperty()
    {

    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-stay-list', [
            'rows' => $this->rows
        ]);
    }
}
