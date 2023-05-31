<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\His\HisIpdNewcase;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\IpdBedmove;
use Livewire\Component;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\his\HisTransferData;
use App\Services\IpdService;
use Illuminate\Validation\Validator;

class NurseIpdNewcaseList extends Component
{
    use WithCachedRows, WithPerPagePagination, DateTimeHelpers;

    public $showEditModal = false;
    public $an;
    public $ward_id, $filter_ward_id, $room_id;
    public $ward_name = '';
    public $wards = [];
    public $rooms = [];
    public $user;

    public $ipd = [
        'an' => '',
        'hn' => '',
        'fullname' => ''
    ];

    public $filters = [
        'hn' => '',
        'an' => '',
    ];

    public IpdBedmove $editing;

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.ward_id' => 'required',
            'editing.bed_id' => 'required|exists:beds,id',
            'editing.bedmove_type_id' => 'required',
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
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
        // New bedmove cache
        $this->editing = $this->makeBlank();

        // Check ipd record
        $ipd = (new IpdService)->create($row['an']);

        // put ipd to bedmove
        $this->an = $ipd->an;
        $this->editing->an = $ipd->an;
        $this->editing->ipd_id = $ipd->id;

        /* Load ward  from His wardcode */
        $ward = Ward::where('ward_code', $row['ward'])->first();

        $this->ward_id = $ward->id ?? 0;
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
        return HisIpdNewcase::selectRaw("an, hn, ward, date_part('year', age(birthday::date)) as ay,
            date_part('month', age(birthday::date)) as am, pname, fname, lname, fullname, regdate, regtime")
            ->whereIn('ward', $this->user->wards()->pluck('ward_code'))
            ->when($this->filters['hn'], function($query, $val) {
                return $query->where('hn', str_pad($val, 9, '0', STR_PAD_LEFT));
            })
            ->when($this->filters['an'], function($query, $val) {
                return $query->where('an', str_pad($val, 9, '0', STR_PAD_LEFT));
            })
            ->when($this->filter_ward_id, function($query, $id) {
                return $query->where('ward', Ward::find($id)->ward_code);
            });
    }

    public function getRowsProperty()
    {
        return $this->cache( function () {
            return $this->applyPagination($this->rowsQuery->orderByRaw('regdate asc, regtime asc'));
        });
    }

    public function tranferCommit()
    {
        $row = [
            'code' => 'ipt',
            'pk_fieldname' => 'an',
            'value' => $this->an,
            'created_by' => $this->user->id
        ];

        HisTransferData::create($row);
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

        $saved = $this->editing->save();

        if($saved) {

            $this->tranferCommit(); // Make a new record his transfer data

            $this->dispatchBrowserEvent('toast-event', [
                'text' => 'ดำเนินการสำเร็จ'
            ]);
        }
    }

    public function mount()
    {
       $this->user = auth()->user();
       $this->wards = $this->user->wards();
       $this->editing = $this->makeBlank();
    }

    public function render()
    {
        return view('livewire.nurse-module.nurse-ipd-new-case-list', [
            'rows' => $this->rows
        ]);
    }
}
