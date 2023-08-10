<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\Bed;
use App\Models\Ipd;
use App\Models\Room;
use App\Models\Ward;
use App\Services\BedmoveService;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Validation\Validator;

class IpdStayList extends Component
{
    public $open = true;
    public $ward_id, $filter_room_id, $room_id;
    public $ward;
    public $rooms = [];
    public $beds = [];
    public $ipd_id;
    public $tab;
    public $search;

    public $bm = [
        'bed_id' => 0
    ];

    public $bedmove;

    protected $listeners = [
        'load:stay' => 'loadStay',
        'stay:set:ward' => 'setWard',
        'move:bed:modal' => 'moveBedModal',
        'stay:refresh' => '$refresh',
        'beds:refresh' => 'bedRefresh'
    ];

    public function rules()
    {
        return [
            'bedmove.ipd_id' => 'required',
            'bedmove.movedate' => 'required',
            'bedmove.movetime' => 'required',
            'bedmove.moved_at' => 'required',
            'bedmove.created_by' => 'required',
            'bedmove.updated_by' => 'required',
            'bedmove.date_for_editing' => '',
            'bedmove.time_for_editing' => '',
            'bedmove.ward_id' => 'required',
            'bedmove.bed_id' => '',
            'bedmove.bedmove_type_id' => 'required',
            'bedmove.from_ref_id' => '',
            'bedmove.to_ref_id' => '',
            'bedmove.delflag' => ''
        ];
    }

    public function setWard($id)
    {
        $this->ward_id = $id;
        $this->loadData();
    }

    public function updatedFilterRoomId($value)
    {
        $this->dispatchBrowserEvent('set-staydata', [
            'beds' => $this->getBeds($value)
        ]);
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
                })
                ->orderBy('display_order', 'asc')
                ->get();
    }

    public function moveBedModal($id)
    {
        $this->ipd_id = $id;
        $ipd = Ipd::find($this->ipd_id);
        $this->bm['bed_id'] = 0;
        $this->room_id = 0;
        $this->bedmove = (new BedmoveService)->create();
        $this->bedmove->ipd_id = $this->ipd_id;
        $this->bedmove->ward_id = $this->ward_id;
        $this->bedmove->from_ref_id = $ipd->current_bedmove_id;
        $this->bedmove->bedmove_type_id = config('ipd.moveself');

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

    public function postBedmove()
    {
        $this->bedmove->moved_at = Carbon::parse($this->bedmove->movedate . ' ' . $this->bedmove->movetime);

        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $saved = $this->bedmove->save();

        if($saved)
        return $this->dispatchBrowserEvent('close-mb-modal', [
            'beds' => $this->getBeds(0)
        ]);
        /*$ipd = Ipd::find($this->ipd_id);
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
        $this->dispatchBrowserEvent('close-mb-modal');*/
    }

    public function mount()
    {
        $this->loadData();
        $this->bedmove = (new BedmoveService)->create();
    }

    public function bedRefresh()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('set-staydata', [
            'beds' => $this->getBeds($this->filter_room_id)
        ]);
    }

    public function loadData()
    {
        $this->ward = Ward::find($this->ward_id);
        $this->rooms = $this->ward ? $this->ward->rooms() : [];
      //  dd($this->rooms);
        $this->filter_room_id = 0;
        $this->beds = $this->getBeds($this->filter_room_id);
        // $this->beds = count($this->rooms) > 0 ? $this->rooms[0]->beds() : [];
        /*$this->dispatchBrowserEvent('set-staydata', [
            'ward' => $this->ward,
            'rooms' => $this->rooms,
            'beds' => $this->beds
        ]);*/
    }

    public function showActionModal($id)
    {
        return $this->dispatchBrowserEvent('showaction-modal', [
            'row' => Bed::find($id)
        ]);
    }

    public function save()
    {

    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-stay-list', [
           // 'rows' => $this->getBeds($this->filter_room_id)
        ]);
    }
}
