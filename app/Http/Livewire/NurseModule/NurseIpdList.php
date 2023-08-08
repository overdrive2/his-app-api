<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Services\BedmoveService;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Bed;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use App\Models\Room;
use App\Services\IpdService;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Livewire\Component;

class NurseIpdList extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $ipd;
    public $wardName = '';
    public $showEditModal = false;
    public $showMoveBedList = false;
    public $user, $ward_id, $current_ward_id, $ipd_id;
    public $room_id, $bed_id;
    public $filter_ward_id;
    public $wards = [];
    public $rooms = [];
    public $tab = 1;

    public IpdBedmove $bm;

    public $listeners = [
        'new:case' => 'newCase'
    ];

    public function rules()
    {
        return [
            'bm.ipd_id' => 'required',
            'bm.bed_id' => 'required|exists:beds,id',
            'bm.ward_id' => 'required',
            'bm.movedate' => 'required',
            'bm.movetime' => 'required',
            'bm.moved_at' => 'required',
            'bm.bedmove_type_id' => 'required',
            'bm.updated_by' => 'required',
            'bm.created_by' => 'required',
            'bm.time_for_editing' => '',
            'bm.date_for_editing' => '',
            'bm.delflag' => 'required'
        ];
    }

    public function updatedTab($value)
    {
        $this->childRefresh($value, $this->filter_ward_id);
       /* switch ($value) {
            case 1:
                //$this->dispatchBrowserEvent('cat:progress');
                $this->emit('open:newcase', true);
                break;
            case 2:
                $this->emit('load:wait', true, $this->filter_ward_id);
                break;
            case 3:
               // $this->dispatchBrowserEvent('cat:progress');
                $this->emit('load:stay', true);
                break;
        }*/
    }

    public function getRooms()
    {
        return Room::where('ward_id', $this->filter_ward_id)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();
    }

    public function getBeds($room_id)
    {
       // dd($room_id);
        return Bed::where('room_id', $room_id)->orderBy('display_order', 'asc')->get();
    }

    public function setBeds($room_id)
    {
       $data = $this->getBeds($room_id);

       $this->dispatchBrowserEvent('set-beds',[
        'beds' => $data
       ]);
    }

    public function newCase($an) //make new case record
    {
        $this->ipd = (new IpdService)->create($an);
        $this->rooms = $this->getRooms();

        $this->bm = (new BedmoveService)->create();
        $this->bm->ipd_id = $this->ipd->id;
        $this->bm->ward_id = $this->filter_ward_id;
        $this->bm->bedmove_type_id = config('ipd.newcase');

        $this->dispatchBrowserEvent('set-rooms', [
            'rooms' => $this->rooms
        ]);

        $this->dispatchBrowserEvent('set-beds', [
            'beds' => $this->getBeds($this->rooms[0]->id)
        ]);

        $this->dispatchBrowserEvent('ncmodal-show', [
            'ipd' => $this->ipd,
          //  'rooms' => $this->rooms,
          //  'beds' => $this->getBeds($this->rooms[0]->id)
        ]);
    }

    public function postNewBed()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $ipd_id = $this->bm->ipd_id;

        $saved = $this->bm->save();

        if($saved) {
            (new IpdService)->tranfered($ipd_id);
            $this->dispatchBrowserEvent('ncmodal-hide');
            $this->dispatchBrowserEvent('toastify', [
                'text' => 'ดำเนินการสำเร็จ'
            ]);
        }
    }

    public function mount()
    {
        $this->user = auth()->user();
      //  $this->wards = $this->user->wards();
      //  $this->filter_ward_id = ($this->wards) ? $this->wards[0]->id : null;
      //  $this->bm = (new BedmoveService)->create();
      //  $this->rooms = $this->getRooms();
    }

    public function childRefresh($tabId, $wardId)
    {
        switch($tabId) {
            case 1:
                $this->emit('set:ward', $wardId);
                break;
            case 2:
                $this->emit('wait:set:ward', $wardId);
                break;
            case 3:
                $this->emit('stay:set:ward', $wardId);
                break;
            default:
            // Nothing
        }
    }

    public function updatedFilterWardId($value)
    {
        $this->childRefresh($this->tab, $value);
    }

    public function updatedWardId($value)
    {
        $rooms = Room::where('ward_id', $value)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();

        $this->bm->bedmove_type_id = ($this->ward_id == $this->current_ward_id) ? config('ipd.moveself') : config('ipd.moveout');
        $this->bm->bed_id = ($this->bm->bedmove_type_id == config('ipd.moveout')) ? null : $this->bm->bed_id;
        $this->dispatchBrowserEvent('rooms-update', [
            'rooms' => $rooms,
        ]);
    }

    public function updatedRoomId($value)
    {
        $beds = Bed::where('room_id', $value)->get();
        $this->bm->bed_id = 0;
        $this->dispatchBrowserEvent('beds-update', ['beds' => $beds]);
    }

    public function newMove($id)
    {
        $this->bm = $this->makeBlank();

        $bedmove = IpdBedmove::where('ipd_id', $id)
            ->orderBy('movedate', 'desc')
            ->orderBy('movetime', 'desc')
            ->first();

        $this->ward_id = $bedmove->ward_id;
        $this->current_ward_id = $bedmove->ward_id;

        $ipd = Ipd::find($bedmove->ipd_id);

        $this->bm->an = $ipd->an;
        $this->bm->ipd_id = $ipd->id;
        $this->bm->ref_id = $bedmove->id;


        $this->dispatchBrowserEvent('modal-show', [
            'ipd' => [
                'an' => $ipd->an,
                'hn' => $ipd->hn,
                'fullname' => $ipd->patient_name,
            ],
            'wards' => $this->user->wards(),
            'rooms' => $this->updatedWardId($this->ward_id),
        ]);
    }

    public function save()
    {
        $this->editing->moved_at = Carbon::parse($this->editing->movedate.' '.$this->editing->movetime);
        $this->bm->ward_id = $this->ward_id;
        // Validate check and dispatch to front-end
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message',['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $this->bm->bed_id = $this->bm->bed_id == null ? 0 : $this->bm->bed_id;

        $saved = $this->bm->save();
      //  $saved = true;
        if($saved) {
            $this->dispatchBrowserEvent('toast-event', [
                'text' => 'ดำเนินการสำเร็จ'
            ]);
        }
    }

    public function getRowsQueryProperty()
    {
        $roomIds = Room::whereIn('ward_id', $this->wards->pluck('id')) //Get Room Id
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->when($this->filter_ward_id, function($query, $ward_id) {
                return $query->where('ward_id', $ward_id);
            })->pluck('id');

        $bedIds = Bed::whereIn('room_id', $roomIds)
            ->pluck('id'); // Get Bed Id

        $ipdIds = IpdBedmove::whereIn('bed_id', $bedIds)->pluck('ipd_id'); // Get IPD ID

        $query = Ipd::whereIn('id', $ipdIds);
          /*  ->when($this->ward_id, function($query, $ward_id){
               // $lastBeds = IpdBedmove::whereIn('bed_id', Room::)
            });*/
        return $query;
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function moveInfo($id)
    {
        $bedmoves = IpdBedmove::where('ipd_id', $id)
            ->orderBy('movedate', 'asc')
            ->orderBy('movetime', 'asc')
            ->get();

        $this->dispatchBrowserEvent('lgmodal-show',[
            'rows' => $bedmoves
        ]);
    }

    public function render()
    {
        return view('livewire.nurse-module.nurse-ipd-list',[
            'rows' => $this->rows
        ]);
    }
}
