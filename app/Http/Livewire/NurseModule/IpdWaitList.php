<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use Livewire\Component;

class IpdWaitList extends Component
{
    use WithPerPagePagination;

    public $ward_id = null;
    public $open = false;

    protected $listeners = [
        'load:wait' => 'loadWait',
        'wait:set:ward' => 'setWard',
        'wait:refresh' => '$refresh',
    ];

    public function setWard($id)
    {
        $this->ward_id = $id;
        $this->dispatchBrowserEvent('swal:close');
        $this->emit('wait:refresh');

    }

    public function loadWait($val, $ward_id)
    {
        $this->ward_id = $ward_id;
        $this->open = $val;
        $this->emit('wait:refresh');
        $this->dispatchBrowserEvent('swal:close');
    }

    public function getRowsQueryProperty()
    {
        return IpdBedmove::where('ward_id', $this->ward_id)->where('bedmove_type_id', config('ipd.moveout'));
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-wait-list',[
            'rows' => ($this->ward_id && $this->open)? $this->rows : [],
        ]);
    }
}
