<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\His\HisIpdNewcase;
use App\Models\Ward;
use Livewire\Component;

class IpdNewcaseList extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public $open = false;
    public $user;

    public $filters = [
        'hn' => '',
        'an' => '',
        'ward_id' => '',
    ];

    public $listeners = [
        'load:data' => 'loadData'
    ];

    public function loadData()
    {
        $this->open = true;
      //  $this->dispatchBrowserEvent('set-ipds', ['data' => $this->rows]);
    }

    public function mount()
    {
       $this->user = auth()->user();
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