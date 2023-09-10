<?php

namespace App\Http\Livewire\OccuInspector;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\OccuIns;
use App\Models\OccuInsDetail;
use App\Models\OccuInsSum;
use App\Models\OccuIpd;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Detail extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $occu_ins_id;
    public OccuInsDetail $editing;
    public $occuIns;
    public $userId;

    protected $queryString = [
        'occu_ins_id' => ['except' => '', 'as' => 'id']
    ];

    protected $listeners = [
        'confirm:commit' => 'commit'
    ];

    public function rules()
    {
        return [
            'editing.occu_ins_event' => 'required',
            'editing.occu_ins_solve' => 'required',
            'editing.occu_ins_id' => '',
            'editing.created_by' => '',
            'editing.updated_by' => '',
        ];
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return OccuInsDetail::make([
            'occu_ins_id' => $this->occu_ins_id,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }

    public function mount()
    {
        $this->userId = auth()->user()->id;
        $this->occuIns = OccuIns::find($this->occu_ins_id);
        $this->editing = $this->makeBlank();
    }

    public function edit($id)
    {
        $this->editing = OccuInsDetail::find($id);
        //dd($this->editing);
        $this->dispatchBrowserEvent('insdetail-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('insdetail-modal-show');
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

        $this->dispatchBrowserEvent('insdetail-modal-close', [
            'msgstatus' => 'done',
        ]);
    }

    public function confirmCommit()
    {
        $this->dispatchBrowserEvent('delete:confirm', [
            'title' => 'ยืนยันการส่งเวรใช่หรือไม่?',
            'text' => '',
            'confirmButtonText' => 'ยืนยัน',
            'cancelButtonText' => 'ยกเลิก',
            'action' => 'confirm:commit',
        ]);
    }

    public function commit()
    {
        $occu = OccuIns::find($this->occu_ins_id);
        $occu->reported = true;
        $occu->reported_at = now();
        $occu->reported_by = $this->userId;
        $occu->save();
        $this->savesum();

        //$this->redirect(route('occu.ins'));
    }

    public function savesum()
    {
        $cc_1 = OccuIpd::where('nurse_shift_date', $this->occuIns->nurse_shift_date)
            ->where('ipd_nurse_shift_id', $this->occuIns->ipd_nurse_shift_id)
            ->where('saved', true)
            ->orderBy('getout', 'desc')->first()->get();
        
        foreach ($cc_1 as $cc1) {
            OccuInsSum::upsert(
                ['occu_ins_id' => $this->occu_ins_id, 'max_ward_id' => $cc1->ward_id, 'max_qty1' => $cc1->getout, 'max_qty2' => $cc1->severe_5],
                ['occu_ins_id'],
                ['max_ward_id', 'max_qty1', 'max_qty2'],
            );
        }

        $cc_1 = OccuIpd::where('nurse_shift_date', $this->occuIns->nurse_shift_date)
            ->where('ipd_nurse_shift_id', $this->occuIns->ipd_nurse_shift_id)
            ->where('saved', true)
            ->orderBy('severe_5', 'desc')->first()->get();

        foreach ($cc_1 as $cc1) {
            OccuInsSum::upsert(
                ['occu_ins_id' => $this->occu_ins_id, 'max_s5_ward_id' => $cc1->ward_id, 'max_s5_qty1' => $cc1->severe_5, 'max_s5_qty2' => $cc1->getout],
                ['occu_ins_id'],
                ['max_s5_ward_id', 'max_s5_qty1', 'max_s5_qty2'],
            );
        }

        $cc_1 = OccuIpd::where('nurse_shift_date', $this->occuIns->nurse_shift_date)
            ->where('ipd_nurse_shift_id', $this->occuIns->ipd_nurse_shift_id)
            ->where('saved', true)
            ->orderBy('occu_percent', 'desc')->first()->get();

        foreach ($cc_1 as $cc1) {
            OccuInsSum::upsert(
                ['occu_ins_id' => $this->occu_ins_id, 'max_occu_ward_id' => $cc1->ward_id, 'max_occu_qty' => $cc1->occu_percent],
                ['occu_ins_id'],
                ['max_occu_ward_id', 'max_occu_qty'],
            );
        }
    }    
    
    public function getRowsQueryProperty()
    {
        $query =  OccuInsDetail::query()
            ->when($this->occu_ins_id, function ($query, $sid) {
                return $query->where('occu_ins_id', $sid);
            })
            ->orderBy('id', 'asc');
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
            'livewire.occu-ins.detail',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
