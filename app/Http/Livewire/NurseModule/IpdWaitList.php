<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Bed;
use App\Models\IpdBedmove;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Validation\Validator;

class IpdWaitList extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $ward_id = null;
    public $open = false;
    public $ipd;
    public IpdBedmove $editing;
    public $rooms = [];

    protected $listeners = [
        'load:wait' => 'loadWait',
        'wait:set:ward' => 'setWard',
        'wait:refresh' => '$refresh',
    ];

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.bed_id' => 'required|exists:beds,id',
            'editing.ward_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.moved_at' => 'required',
            'editing.from_ref_id' => 'required',
            'editing.bedmove_type_id' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
            'editing.delflag' => 'required'
        ];
    }

    public function setWard($id)
    {
       $this->ward_id = $id;
       $this->open = true;
       $this->emit('wait:refresh');
       $this->dispatchBrowserEvent('swal:close');

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
        return
            IpdBedmove::where('ward_id', $this->ward_id)
                ->where('to_ref_id', '=', 0)
                ->where('bedmove_type_id', config('ipd.moveout'));
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function getRooms()
    {
        return Room::where('ward_id', $this->ward_id)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();
    }

    public function getBeds($room_id)
    {
        return Bed::where('room_id', $room_id)->orderBy('display_order', 'asc')->get();
    }

    public function setBeds($room_id)
    {
       $data = $this->getBeds($room_id);

       $this->dispatchBrowserEvent('set-beds',[
        'beds' => $data
       ]);
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return IpdBedmove::make([
            'ipd_id' => $this->ipd->id ?? 0,
            'ward_id' => $this->ward_id,
            'movedate' => $this->getCurrentDate(),
            'movetime' => $this->getCurrentTime(),
            'from_ref_id' => 0,
            'bedmove_type_id' => config('ipd.moverecp'),
            'created_by' => $userId,
            'updated_by' => $userId,
            'delflag' => false
        ]);
    }

    public function new($id)
    {
        $bdm = IpdBedmove::find($id);
        $this->ipd = $bdm->ipd();
        $this->rooms = $this->getRooms();

        $this->editing = $this->makeBlank();
        $this->editing->from_ref_id = $bdm->id;

        $this->dispatchBrowserEvent('set-rooms', [
            'rooms' => $this->rooms
        ]);

        $this->dispatchBrowserEvent('set-beds', [
            'beds' => $this->getBeds($this->rooms[0]->id)
        ]);
        $this->dispatchBrowserEvent('waitcase-modal-show', [
            'ipd' => $this->ipd
        ]);
    }

    public function save()
    {
        $this->editing->moved_at = Carbon::parse($this->editing->movedate.' '.$this->editing->movetime);
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $this->editing->save();

        $this->dispatchBrowserEvent('waitcase-modal-hide');
    }

    public function mount()
    {
        $this->editing = $this->makeBlank();
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-wait-list',[
            'rows' => $this->open ? $this->rows : [],
        ]);
    }
}
