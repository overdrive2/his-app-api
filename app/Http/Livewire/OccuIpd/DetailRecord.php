<?php

namespace App\Http\Livewire\OccuIpd;

use App\Models\OccuIpdRecord;
use App\Models\OccuIpdStaffList;
use Livewire\Component;

class DetailRecord extends Component
{
    public $occu_ipd_id;

    public function getRowsQueryProperty()
    {
        $query =  OccuIpdRecord::query()
        ->when($this->occu_ipd_id, function ($query, $sid) {
            return $query->where('occu_ipd_id', $sid);
        })
            ->orderBy('id','asc');
        return $query;
    }

    public function getRowCountProperty()
    {
        return $this->rowsQuery->count();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function render()
    {
        return view(
            'livewire.occu-ipd.detail-record',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
