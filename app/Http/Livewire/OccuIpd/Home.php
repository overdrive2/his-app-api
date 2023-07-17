<?php

namespace App\Http\Livewire\OccuIpd;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\IpdNurseShift;
use App\Models\OccuIpd;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Home extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public OccuIpd $editing;
    public $filters = [
        'sdate' => '',
        'edate' => '',
        'shiftId' => 0,
    ];
    public $nurseshifts = [];
    public $wards = [];

    public function rules()
    {
        return [
            'editing.nurse_shift_date' => 'required',
            'editing.nurse_shift_time' => 'required',
            'editing.ward_id' => 'required|exists:wards,id',
            'editing.ipd_nurse_shift_id' => 'required|exists:ipd_nurse_shifts,id',
            'editing.occu_status_id' => '',
            'editing.note' => '',
            'editing.getin' => 0,
            'editing.getnew' => 0,
            'editing.getmove' => 0,
            'editing.moveout' => 0,
            'editing.discharge' => 0,
            'editing.getout' => 0,
            'editing.severe_1' => 0,
            'editing.severe_2' => 0,
            'editing.severe_3' => 0,
            'editing.severe_4' => 0,
            'editing.severe_5' => 0,
            'editing.severe_6' => 0,
            'editing.created_by' => '',
            'editing.updated_by' => '',
            'editing.delflag' => false,
            'editing.saved' => false,
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
        ];
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return OccuIpd::make([
            'nurse_shift_date' => $this->getCurrentDate(),
            'nurse_shift_time' => $this->getCurrentTime(),
            'getin' => 0,
            'getnew' => 0,
            'getmove' => 0,
            'moveout' => 0,
            'discharge' => 0,
            'getout' => 0,
            'occu_status_id' => 1,
            'severe_1' => 0,
            'severe_2' => 0,
            'severe_3' => 0,
            'severe_4' => 0,
            'severe_5' => 0,
            'severe_6' => 0,
            'created_by' => $userId,
            'updated_by' => $userId,
            'delflag' => false,
            'saved' => false,
            'note' => '',
        ]);
    }

    public function mount()
    {
        // $this->perPage = 3;
        $this->editing = $this->makeBlank();
        $this->nurseshifts = IpdNurseShift::all();
        $this->wards = auth()->user()->wards();
        $this->filters['edate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
        $this->filters['sdate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
    }

    public function edit($id)
    {
        $this->editing = OccuIpd::find($id);
        $this->dispatchBrowserEvent('ipdmain-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipdmain-modal-show');
    }

    public function save()
    {
        //dd($this->editing);
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

        $this->dispatchBrowserEvent('ipdmain-modal-close', [
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
        $query =  OccuIpd::query()
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
            'livewire.occu-ipd.home',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
