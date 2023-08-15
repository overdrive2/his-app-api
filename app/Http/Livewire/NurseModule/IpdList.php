<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Models\Bed;
use App\Models\IpdBedmove;
use App\Models\Room;
use App\Models\Ward;
use App\Services\BedmoveService;
use Livewire\Component;

class IpdList extends Component
{
    use WithCachedRows;

    public $ward_id = '0';
    public $room_id = '0';
    public $wards = [];
    public $rooms = [];
    public $ward;
    public IpdBedmove $editing;

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.moved_at' => 'required',
            'editing.created_by' => 'required',
            'editing.updated_by' => 'required',
            'editing.date_for_editing' => '',
            'editing.time_for_editing' => '',
            'editing.ward_id' => 'required',
            'editing.bed_id' => '',
            'editing.bedmove_type_id' => 'required',
            'editing.from_ref_id' => '',
            'editing.to_ref_id' => '',
            'editing.delflag' => ''
        ];
    }

    public function mount()
    {
        $this->wards = auth()->user()->wards();
        $this->ward_id = auth()->user()->current_ward_id;

        if($this->ward_id) {
            $this->ward = Ward::find($this->ward_id);
            $this->rooms = $this->ward->rooms();
        }

        $this->editing = (new BedmoveService)->create();
    }

    public function new($typeId)
    {
        $this->editing = (new BedmoveService)->create();
        $this->editing->bedmove_type_id = $typeId;
        return $this->editing;
    }

    public function bedmove()
    {
        $this->editing = (new BedmoveService)->create();
        $this->editing->bedmove_type_id = config('ipd.moveself');
        return ;
    }

    public function wardmove()
    {
        $this->editing = (new BedmoveService)->create();
        $this->editing->bedmove_type_id = config('ipd.moveout');
        return ;
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('set-acmodal', [
            'row' => Bed::find($id)
        ]);
    }

    public function updatedWardId($value)
    {
        $this->ward = $value > 0 ? Ward::find($value) : null;
        $this->dispatchBrowserEvent('set-rooms', [
            'rooms' => $value > 0 ? Room::where('ward_id', $value)->get() : []
        ]);
    }

    public function getRowsQueryProperty()
    {
        return Bed::query()
            ->whereIn('room_id', Room::where('ward_id', $this->ward_id)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->when($this->room_id, function($query, $room_id){
                return $this->where('room_id', $room_id);
            })
            ->pluck('id'));
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->rowsQuery->orderBy('display_order', 'asc')
            ->get();
        });
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-list', [
            'rows' => $this->ward_id ? $this->rows : []
        ]);
    }
}
