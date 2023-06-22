<?php

namespace App\Http\Livewire\NurseInspector;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\IpdNurseShift;
use App\Models\IpdOccu;
use Carbon\Carbon;
use Livewire\Component;

class Home extends Component
{
    use WithPerPagePagination;

    public $ipd_id, $patient_id;
    public $an = '1234';
    public $filters = [
        'sdate' => '',
        'edate' => '',
        'shiftId' => 0,
    ];

    public function post()
    {
        dd($this->search);
    }

    public function setDate($date)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $date);
        return $date->format('Y-m-d');
    }

    public function getRowsQueryProperty()
    {
        $query =  IpdOccu::query()
            ->when($this->filters['shiftId'], function($query,$sid) {
                return $query->where('ipd_nurse_shift_id', $sid);
            })
            ->when($this->filters['sdate'] && $this->filters['edate'], function($query) { 
                $sdate = $this->setDate($this->filters['sdate']);
                $edate = $this->setDate($this->filters['edate']);

                return $query->whereBetween('nurse_shift_date', [$sdate, $edate]);
             });
        return $query;     
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view('livewire.nurse-inspector.home', [
            'ipd_nurse_shifts' => IpdNurseShift::all(),
            'rows' => $this->rows,
        ]);
    }
}
