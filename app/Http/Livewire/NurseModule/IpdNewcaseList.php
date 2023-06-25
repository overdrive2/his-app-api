<?php
namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Bed;
use App\Models\His\HisIpdNewcase;
use App\Models\IpdBedmove;
use App\Models\Room;
use App\Models\Ward;
use App\Services\IpdService;
use Illuminate\Validation\Validator;
use Livewire\Component;

class IpdNewcaseList extends Component
{
    use WithCachedRows, WithPerPagePagination, DateTimeHelpers;

    public $open = false;
    public $ward_id;
    public $user, $ipd;
    public IpdBedmove $editing;
    public $rooms = [];

    public $filters = [
        'hn' => '',
        'an' => '',
        'search' => ''
    ];

    public $listeners = [
        'load:newcase' => 'loadData',
        'set:ward' => 'setWard',
        'refresh:newcase' => 'refreshNewcase',
        'self:refresh' => '$refresh',
        'open:newcase' => 'setOpen'
    ];

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.bed_id' => 'required|exists:beds,id',
            'editing.ward_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.bedmove_type_id' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
            'editing.delflag' => 'required'
        ];
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return IpdBedmove::make([
            'ipd_id' => $this->ipd ? ($this->ipd->id ?? 0) : null,
            'ward_id' => $this->ward_id,
            'movedate' => $this->getCurrentDate(),
            'movetime' => $this->getCurrentTime(),
            'bedmove_type_id' => config('ipd.newcase'),
            'created_by' => $userId,
            'updated_by' => $userId,
            'delflag' => false
        ]);
    }

    public function setOpen($val){
        $this->open = $val;
        $this->emit('self:refresh');
    }

    public function refreshNewcase()
    {
       $this->dispatchBrowserEvent('update-newcase-count', [
            'count' => $this->rowsQuery->count()
       ]);

      // $this->emit('self:refresh');
    }

    public function getNewcaseCount()
    {
        return $this->rowsQuery->count();
    }

    public function setWard($id)
    {
        $this->ward_id = $id;
        $this->dispatchBrowserEvent('swal:close');
        //dd($this->ward_id);
    }

    public function getRowsQueryProperty()
    {
        return HisIpdNewcase::selectRaw("an, hn, ward, date_part('year', age(birthday::date)) as ay,
            date_part('month', age(birthday::date)) as am, pname, fname, lname, fullname, regdate, regtime")
            ->whereIn('ward', $this->user->wards()->pluck('ward_code'))
            ->where('ward', Ward::find($this->ward_id)->ward_code)
            ->when($this->filters['hn'], function($query, $val) {
                return $query->where('hn', str_pad($val, 9, '0', STR_PAD_LEFT));
            })
            ->when($this->filters['an'], function($query, $val) {
                return $query->where('an', str_pad($val, 9, '0', STR_PAD_LEFT));
            });
    }

    public function new($an)
    {
        $this->ipd = (new IpdService)->create($an);
        $this->rooms = $this->getRooms();
        $this->dispatchBrowserEvent('set-rooms', [
            'rooms' => $this->rooms
        ]);

        $this->dispatchBrowserEvent('set-beds', [
            'beds' => $this->getBeds($this->rooms[0]->id)
        ]);

        $this->editing = $this->makeBlank();

        $this->dispatchBrowserEvent('newcase-modal-show', [
            'ipd' => $this->ipd
        ]);
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

    public function save()
    {
       $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $ipd_id = $this->editing->ipd_id;

        $saved = $this->editing->save();

        if($saved) {
            (new IpdService)->tranfered($ipd_id);
            $this->dispatchBrowserEvent('newcase-modal-hide');
            $this->dispatchBrowserEvent('toastify', [
                'text' => 'ดำเนินการสำเร็จ'
            ]);
            $this->emit('self:refresh');
        }
    }

    public function mount()
    {
        $this->editing = $this->makeBlank();
        $this->rooms = $this->getRooms();
    }

    public function getRowsProperty()
    {
        return $this->cache( function () {
            return $this->applyPagination($this->rowsQuery->orderByRaw('regdate asc, regtime asc'));
        });
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-newcase-list', [
            'rows' => $this->open ? $this->rows : []
        ]);
    }
}
