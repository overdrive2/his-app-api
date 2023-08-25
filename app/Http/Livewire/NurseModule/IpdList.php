<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\Traits\BedmoveHelpers;
use App\Models\Bed;
use App\Models\his\HisTransferData;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Ward;
use App\Services\BedmoveService;
use App\Services\IpdService;
use Livewire\Component;

class IpdList extends Component
{
    use WithCachedRows, BedmoveHelpers;

    public $ward_id = '0';
    public $room_id = '0';
    public $to_ward_id = '0';
    public $wards = [];
    public $rooms = [];
    public $ward;
    public $selectedId;
    public $search;
    public $showOff = false;

    protected $listeners = [
        'ipd-list:refresh' => '$refresh'
    ];

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

    public function makeNewcase($an, $bed)
    {
        $this->editing = $this->makeBlank();
        $ipd = (new IpdService)->create($an);
        $this->editing->bedmove_type_id = config('ipd.newcase');
        $this->editing->an = $ipd->an;
        $this->editing->ipd_id = $ipd->id;
        $this->editing->bed_id = $bed['id'];
        $this->editing->ward_id = $bed['wardId'];
        $this->to_ward_id = $bed['wardId'];
        return;
    }

    public function new($typeId)
    {
        $this->editing = (new BedmoveService)->create();
        $this->editing->bedmove_type_id = $typeId;
        return $this->editing;
    }

    public function selectRow($id)
    {
        $this->selectedId = $id;
        $this->showOff = true;
    }

    /** Commit AN to HIS */
    public function tranferCommit($an)
    {
        $row = [
            'code' => 'ipt',
            'pk_fieldname' => 'an',
            'value' => $an,
            'created_by' => auth()->user()->id
        ];

        HisTransferData::create($row);
    }

    public function save()
    {
        $this->editing->ward_id = $this->to_ward_id;
        $this->bedMoveValidate('err-message');

        $move_type = $this->editing->bedmove_type_id;
        $saved = $this->editing->save();

        if($move_type == config('ipd.newcase') && $saved)
            return $this->dispatchBrowserEvent('newcase-success');

        $this->dispatchBrowserEvent('move-success');
    }

    public function bedsQuery($empty)
    {
        return
            Bed::whereIn('room_id',
                Room::where('ward_id', $this->ward_id)
                    ->where('room_type_id', '<>', config('ipd.waitroom'))
                    ->pluck('id')
            )
            ->when($empty, function($query){
                return $query->where('empty_flag', true);
            })
            ->orderBy('display_order', 'asc');
    }

    public function bedFilter($empty)
    {
        $this->dispatchBrowserEvent('set-beds',
        [
            'beds' => $this->bedsQuery($empty)->get()
        ]);
        return ;
    }

    public function bedmove($id)
    {
        $this->editing = $this->makeBlank();

        $bd = Bed::find($id);
        $this->editing->from_ref_id = $bd->last_bedmove_id;
        $this->editing->bedmove_type_id = config('ipd.moveself');

        $lbm = IpdBedmove::find($bd->last_bedmove_id);
        $this->editing->ipd_id = $lbm->ipd_id;
        $this->editing->ward_id = $lbm->ward_id;

        $this->dispatchBrowserEvent('set-bededit', [
            'data' => [
                'from' => $bd->bed_name,
                'to' => '-',
                'ipd' => $bd->ipd,
                'beds' => $this->bedsQuery(true)->get()
            ]
        ]);

        return ;
    }

    public function wardmove($id)
    {
        $this->editing = $this->makeBlank();

        $bd = Bed::find($id);
        $this->editing->from_ref_id = $bd->last_bedmove_id;
        $this->editing->bedmove_type_id = config('ipd.moveout');
        $this->editing->bed_id = 0;
        $lbm = IpdBedmove::find($bd->last_bedmove_id);
        $this->editing->ipd_id = $lbm->ipd_id;
        $this->editing->ward_id = $lbm->ward_id;
        $this->to_ward_id = 0;
        $this->dispatchBrowserEvent('set-bededit', [
            'data' => [
                'from' => $bd->bed_name,
                'to' => '-',
                'ipd' => $bd->ipd,
                'wards' => Ward::where('active', true)->orderBy('name', 'asc')->get()
            ]
        ]);

        return ;
    }

    public function edit($id)
    {
        $this->selectedId = $id;
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
            ->whereIn('room_id',
                Room::where('ward_id', $this->ward_id)
                    ->where('room_type_id', '<>', config('ipd.waitroom'))
                    ->when($this->room_id, function($query, $room_id){
                         return $query->where('room_id', $room_id);
                    })
                ->pluck('id')
            )
            ->when($this->search, function($query, $search) { // กรณีค้นหาชื่อ
                return $query->whereIn('last_bedmove_id',
                    Ipd::whereIn('patient_id', Patient::where('fname', 'like', $search.'%')->pluck('id'))
                        ->pluck('current_bedmove_id')
                );
            });
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
