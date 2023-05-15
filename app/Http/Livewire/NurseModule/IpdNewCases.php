<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\HisIpdNewcase;
use App\Models\Ward;
use App\Models\IpdBedmove;
use Livewire\Component;

class IpdNewCases extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $showEditModal = false;
    public $an;
    public $ward_id;
    public $wards = [];
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
            'editing.created_by' => 'required'
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;

        return IpdBedmove::make([
            'bed_id' => 0,
            'updated_by' => $uid,
            'created_by' => $uid
           ]);
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
    }

    public function show()
    {
        $this->dispatchBrowserEvent('show-clients');
    }

    public function getRowsQueryProperty()
    {
        return HisIpdNewcase::query()
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
        dd($this->ipd);
    }

    public function mount()
    {
       $this->wards = auth()->user()->wards();
       $this->editing = $this->makeBlank();
    }

    public function render()
    {
        return view('livewire.nurse-module.ipd-new-cases', [
            'rows' => $this->rows
        ]);
    }
}
