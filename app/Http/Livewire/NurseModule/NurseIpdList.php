<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\BedmoveService;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Bed;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use App\Models\Room;
use Illuminate\Validation\Validator;
use Livewire\Component;

class NurseIpdList extends Component
{
    use WithPerPagePagination, DateTimeHelpers, BedmoveService;

    public $wardName = '';
    public $showEditModal = false;
    public $showMoveBedList = false;
    public $user, $ward_id, $current_ward_id, $ipd_id;
    public $room_id;
    public $filter_ward_id;
    public $wards = [];
    public $rooms = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->wards = $this->user->wards();
       // dd($this->wards);
        $this->editing = $this->makeBlank();
    }

    public function updatedFilterWardId($val)
    {
        $this->emit('set:filter', 'ward_id', $val);
    }

    public function updatedWardId($value)
    {
        $rooms = Room::where('ward_id', $value)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();

        $this->editing->bedmove_type_id = ($this->ward_id == $this->current_ward_id) ? config('ipd.moveself') : config('ipd.moveout');
        $this->editing->bed_id = ($this->editing->bedmove_type_id == config('ipd.moveout')) ? null : $this->editing->bed_id;
        $this->dispatchBrowserEvent('rooms-update', [
            'rooms' => $rooms,
        ]);
    }

    public function updatedRoomId($value)
    {
        $beds = Bed::where('room_id', $value)->get();
        $this->editing->bed_id = 0;
        $this->dispatchBrowserEvent('beds-update', ['beds' => $beds]);
    }

    public function newMove($id)
    {
        $this->editing = $this->makeBlank();

        $bedmove = IpdBedmove::where('ipd_id', $id)
            ->orderBy('movedate', 'desc')
            ->orderBy('movetime', 'desc')
            ->first();

        $this->ward_id = $bedmove->ward_id;
        $this->current_ward_id = $bedmove->ward_id;

        $ipd = Ipd::find($bedmove->ipd_id);

        $this->editing->an = $ipd->an;
        $this->editing->ipd_id = $ipd->id;
        $this->editing->ref_id = $bedmove->id;


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
        $this->editing->ward_id = $this->ward_id;

        // Validate check and dispatch to front-end
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message',['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();
        $this->editing->bed_id = $this->editing->bed_id == null ? 0 : $this->editing->bed_id;

        $saved = $this->editing->save();
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
