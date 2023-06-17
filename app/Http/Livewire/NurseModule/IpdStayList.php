<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\Bed;
use App\Models\Ward;
use Livewire\Component;

class IpdStayList extends Component
{
    public $open = false;
    public $ward_id;
    public $ward;
    public $rooms = [];
    public $beds = [];

    protected $listeners = [
        'load:stay' => 'loadStay'
    ];

    public function loadStay($val)
    {
        $this->open = $val;
        $this->loadData();
    }

    public function mount()
    {
        $this->loadData();
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
