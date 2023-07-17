<?php

namespace App\Http\Livewire\OccuInspector;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\IpdNurseShift;
use App\Models\OccuIns;
use App\Models\OccuInsBranch;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Home extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public OccuIns $editing;
    public $filters = [
        'sdate' => '',
        'edate' => '',
        'shiftId' => 0,
    ];
    public $nurseshifts = [];
    public $branchs = [];

    public function rules()
    {
        return [
            'editing.nurse_shift_date' => 'required',
            'editing.nurse_shift_time' => 'required',
            'editing.ipd_nurse_shift_id' => 'required|exists:ipd_nurse_shifts,id',
            'editing.occu_status_id' => '',
            'editing.occu_ins_branch_id' => 'required|exists:occu_ins_branches,id',
            'editing.note' => '',
            'editing.reported' => '',
            'editing.approved' => '',
            'editing.line_noti' => '',
            'editing.created_by' => '',
            'editing.updated_by' => '',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
        ];
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return OccuIns::make([
            'nurse_shift_date' => $this->getCurrentDate(),
            'nurse_shift_time' => $this->getCurrentTime(),
            'occu_status_id' => 1,
            'occu_ins_branch_id' => 1,
            'created_by' => $userId,
            'updated_by' => $userId,
            'reported' => false,
            'approved' => false,
            'line_noti' => false,
            'note' => '',
        ]);
    }

    public function mount()
    {
        // $this->perPage = 3;
        $this->editing = $this->makeBlank();
        $this->nurseshifts = IpdNurseShift::all();
        $this->branchs = OccuInsBranch::all();
        $this->filters['edate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
        $this->filters['sdate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
    }

    public function edit($id)
    {
        $this->editing = OccuIns::find($id);
        //dd($this->editing);
        $this->dispatchBrowserEvent('insmain-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('insmain-modal-show');
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

        $saved = $this->editing->save();

        if (!$saved)
            return $this->dispatchBrowserEvent('swal:error', [
                'title' => 'ABC title',
                'text' => 'ABC text',
            ]);
        //$saved = false;

        $this->dispatchBrowserEvent('insmain-modal-close', [
            'msgstatus' => 'done',
        ]);
    }

    public function setDate($date)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $date);
        return $date->format('Y-m-d');
    }

    public function getRowsQueryProperty()
    {
        $query =  OccuIns::query()
            ->when($this->filters['shiftId'], function ($query, $sid) {
                return $query->where('ipd_nurse_shift_id', $sid);
            })
            ->when($this->filters['sdate'] && $this->filters['edate'], function ($query) {
                $sdate = $this->setDate($this->filters['sdate']);
                $edate = $this->setDate($this->filters['edate']);

                return $query->whereBetween('nurse_shift_date', [$sdate, $edate]);
            })
            ->orderBy('nurse_shift_date','asc')
            ->orderBy('nurse_shift_time','asc');
        return $query;
    }

    public function getRowCountProperty()
    {
        return $this->rowsQuery->count();
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view(
            'livewire.occu-ins.home',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
