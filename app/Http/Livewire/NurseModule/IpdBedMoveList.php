<?php

namespace App\Http\Livewire\NurseModule;

use App\Models\Bed;
use App\Models\IpdBedmove;
use App\Models\Room;
use Livewire\Component;

class IpdBedMoveList extends Component
{
    public $ipd_id, $ward_id, $room_id, $user;
    public $ipd;
    public IpdBedmove $editing;

    public $selectedId;

    protected $listeners = [
        'delete:bedmove' => 'deleteBedMove'
    ];

    protected
        $queryString = [
            'ipd_id' => ['except' => '', 'as'=> 'id']
        ];

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.bed_id' => 'required|exists:beds,id',
            'editing.ward_id' => 'required',
            'editing.room_id' => 'required',
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
            ->orderBy('movetime', 'asc')
            ->get();
    }

    public function edit($id)
    {
        $this->editing = IpdBedmove::find($id);
        $this->ipd = $this->editing->ipd;
        $this->getRooms($this->editing->ward_id);
        $this->dispatchBrowserEvent('bded-modal-show', [
            'ipd' => $this->ipd,
        ]);

    }

    public function getRooms($value)
    {
        $rooms = Room::where('ward_id', $value)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();
        $this->editing->room_id = 0;
       // $this->editing->bedmove_type_id = ;
       // $this->editing->bed_id = ($this->editing->bedmove_type_id == config('ipd.moveout')) ? null : $this->editing->bed_id;

        $this->dispatchBrowserEvent('rooms-update', [
            'rooms' => $rooms,
        ]);
    }

    public function getBeds($value)
    {
        $beds = Bed::where('room_id', $value)->get();
        $this->editing->bed_id = 0;
        $this->dispatchBrowserEvent('beds-update', ['beds' => $beds]);
    }

    public function updatedEditing($value, $paraName)
    {
        switch ($paraName) {
            case 'ward_id':
                $this->getRooms($value);
                break;
            case 'room_id':
                $this->getBeds($value);
                break;
            default:
                # code...
                break;
        }

    }

    public function save()
    {

    }

    public function deleteBedMove()
    {
        $bm = IpdBedmove::where('id', $this->selectedId)->first();
        $deleted = $bm->delete();

        if($deleted) $this->dispatchBrowserEvent('toastify', ['text' => 'ลบข้อมูลสำเร็จ...']);
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
