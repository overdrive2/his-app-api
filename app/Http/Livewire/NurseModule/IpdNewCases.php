<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\HisIpdNewcase;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\IpdBedmove;
use Livewire\Component;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Services\IpdService;

class IpdNewCases extends Component
{
    use WithCachedRows, WithPerPagePagination, DateTimeHelpers;

    public $showEditModal = false;
    public $an;
    public $ward_id, $room_id;
    public $ward_name = '';
    public $wards = [];
    public $rooms = [];

    public $ipd = [
        'an' => '',
        'hn' => '',
        'fullname' => ''
    ];

    public IpdBedmove $editing;

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.bed_id' => 'required',
            'editing.bedmove_type_id' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.time_for_editing' => '',
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;

        return IpdBedmove::make([
            'bed_id' => 0,
            'updated_by' => $uid,
            'created_by' => $uid,
            'movetime' => $this->getCurrentTime(),
            'bedmove_type_id' => config('ipd.newcase')
           ]);
    }

    public function updatedRoomId($value)
    {
        $beds = Bed::where('room_id', $value)->get();
        $this->editing->bed_id = 0;
        $this->dispatchBrowserEvent('beds-update', ['beds' => $beds]);
    }

    public function new($row)
    {
        $this->editing = $this->makeBlank();
        $this->editing->an = $row['an'];

        /* Load ward by wardcode */
        $ward = Ward::where('wardcode', $row['ward'])->first();

        $this->ward_id = $ward->id;
        $this->ward_name = $this->ward_id ? Ward::find($this->ward_id)->name : ' ';
        $this->rooms = Room::where('ward_id', $this->ward_id)->get();
        $this->dispatchBrowserEvent('rooms-update', ['rooms' => $this->rooms]);
        /* end load ward */
    }

    public function show()
    {
        $this->dispatchBrowserEvent('show-clients');
    }

    public function getRowsQueryProperty()
    {
        return HisIpdNewcase::selectRaw("an, hn, ward, date_part('year', age(birthday)) as ay,
            date_part('month', age(birthday)) as am, pname, fname, lname, fullname, regdate, regtime")
            ->when($this->ward_id, function($query, $id) {
                return $query->where('ward', Ward::find($id)->wardcode);
            });
    }

    public function getRowsProperty()
    {
        return $this->cache( function () {
            return $this->applyPagination($this->rowsQuery->orderByRaw('regdate asc, regtime asc'));
        });
    }

    public function save()
    {
        dd($this->editing);
        dd($this->ipd);
    }

    public function mount()
    {
       $ipd = (new IpdService())->create('123456');
       dd($ipd);
       $this->wards = auth()->user()->wards();
      // $this->rooms = Room::all();
       $this->editing = $this->makeBlank();
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-new-cases', [
            'rows' => $this->rows
        ]);
    }
}
