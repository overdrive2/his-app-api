<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\Bed;
use App\Models\Ipd;
use App\Models\Room;
use App\Models\Ward;
use App\Services\BedmoveService;
use Carbon\Carbon;
use Livewire\Component;

class IpdStayList extends Component
{
    public $open = true;
    public $ward_id, $filter_room_id, $room_id;
    public $ward;
    public $rooms = [];
    public $beds = [];
    public $ipd_id;
    public $tab;

    public $bm = [
        'bed_id' => 0
    ];

    public $wm;

    protected $listeners = [
        'load:stay' => 'loadStay',
        'stay:set:ward' => 'setWard',
        'move:bed:modal' => 'moveBedModal',
        'stay:refresh' => '$refresh'
    ];

    public function rules()
    {
        return [
            'wm.ipd_id' => 'required',
            'wm.movedate' => 'required',
            'wm.movetime' => 'required',
            'wm.moved_at' => 'required',
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

    public function getBeds($room_id)
    {
        return Bed::when($room_id, function($query, $value) {
                return $query->where('room_id', $value);
            })->when(!$room_id, function($query) {
                $rmIds = Room::where('ward_id', $this->ward_id)
                ->where('room_type_id', '<>', config('ipd.waitroom'))
                ->pluck('id');
                return $query->whereIn('room_id', $rmIds);
            })->orderBy('display_order', 'asc')
            ->get();
    }

    public function updatedFilterRoomId($value)
    {
        $this->dispatchBrowserEvent('set-rbeds-filter', [
            'beds' => $this->getBeds($value)
        ]);
    }

    public function moveBedModal($id)
    {
        $this->ipd_id = $id;
        $this->bm['bed_id'] = 0;
        $this->room_id = 0;
        $this->dispatchBrowserEvent('open-mb-modal', [
            'rooms' => $this->rooms,
            'beds' => $this->getBeds($this->room_id)
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

        if ($bedmove->bed_id == 0)
            return $this->dispatchBrowserEvent('bd-err-message', [
                'errors' => ['bedmove' => 'โปรดระบุเตียง..!']
            ]);

        $bedmove->moved_at = Carbon::parse($bedmove->movedate . ' ' . $bedmove->movetime);
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
        $this->filter_room_id = 0;
        $this->beds = $this->getBeds($this->filter_room_id);
        // $this->beds = count($this->rooms) > 0 ? $this->rooms[0]->beds() : [];
        /*$this->dispatchBrowserEvent('set-staydata', [
            'ward' => $this->ward,
            'rooms' => $this->rooms,
            'beds' => $this->beds
        ]);*/
    }

    public function getRowsProperty()
    {
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-stay-list');
    }
}
