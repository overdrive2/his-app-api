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
    public $ward_id;
    public $user;

    public $filters = [
        'hn' => '',
        'an' => '',
        'search' => ''
    ];

    public $listeners = [
        'load:newcase' => 'loadData',
        'set:ward' => 'setWard',
        'refresh:newcase' => 'refreshNewcase',
        'self:refresh' => '$refresh'
    ];

    public function refreshNewcase()
    {
       $this->dispatchBrowserEvent('update-newcase-count', [
            'count' => $this->rowsQuery->count()
       ]);

       $this->emit('self:refresh');
    }

    public function getNewcaseCount()
    {
        return $this->rowsQuery->count();
    }

    public function setWard($id)
    {
        $this->ward_id = $id;
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

    public function mount()
    {

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
