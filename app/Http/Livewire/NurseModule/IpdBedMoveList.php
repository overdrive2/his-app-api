<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\Traits\BedmoveService;
use App\Models\IpdBedmove;
use Livewire\Component;

class IpdBedMoveList extends Component
{
    use BedmoveService;

    public $ipd_id, $ward_id, $room_id, $user;

    protected $listeners = [
        'delete:bedmove' => 'deleteBedMove'
    ];

    protected
        $queryString = [
            'ipd_id' => ['except' => '', 'as'=> 'id']
        ];

    public function deleteConfirm($id)
    {
        $this->selectedId = $id;

        $this->dispatchBrowserEvent('delete:confirm', [
            'action' => 'delete:bedmove'
        ]);
    }
    public function getRowsProperty()
    {
        return IpdBedmove::where('ipd_id', $this->ipd_id)
            ->orderBy('movedate', 'asc')
            ->orderBy('movedate', 'asc')
            ->get();
    }

    public function deleteBedMove()
    {
        if($this->delete()) $this->dispatchBrowserEvent('swal:success');
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-bed-move-list', [
            'rows' => $this->rows
        ]);
    }
}
