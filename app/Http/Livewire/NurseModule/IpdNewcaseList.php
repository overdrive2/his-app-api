<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\His\HisIpdNewcase;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use App\Models\Ward;
use App\Services\IpdService;
use Livewire\Component;

class IpdNewcaseList extends Component
{
    use WithCachedRows, WithPerPagePagination, DateTimeHelpers;

    public $open = false;
    public $user, $ipd;
    public $ward = [
        'id' => '',
        'name' => ''
    ];

    public $filters = [
        'hn' => '',
        'an' => '',
        'ward_id' => '',
    ];

    public $listeners = [
        'load:data' => 'loadData',
        'set:an' => 'setAn',
        'set:filter' => 'setFilter',
        'new:bedmove' => 'newBedmove'
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

    public function newBedmove($an)
    {
        $this->editing = $this->makeBlank();
        $this->editing->ipd_id = Ipd::where('an', $an)->value('id');
    }

    public function setFilter($name, $value)
    {
        $this->filters[$name] = $value;
    }

    public function setAn($an)
    {
      $ward_code = HisIpdNewcase::where('an', $an)->value('ward');
      $this->ward = Ward::where('ward_code', $ward_code)->first();
      $ipd = (new IpdService)->create($an);
      $this->dispatchBrowserEvent('set-ipd', [
        'data' => $ipd
      ]);
    }

    public function loadData()
    {
        $this->open = true;
      //  $this->dispatchBrowserEvent('set-ipds', ['data' => $this->rows]);
    }

    public function mount()
    {
       $this->user = auth()->user();
       $this->editing = IpdBedmove::make();
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
            ->when($this->filters['ward_id'], function($query, $id) {
                return $query->where('ward', Ward::find($id)->ward_code);
            });
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
