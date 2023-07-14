<?php

namespace App\Http\Livewire\OccuInspector;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\OccuIns;
use App\Models\OccuInsDetail;
use Carbon\Carbon;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Detail extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $occu_ins_id;
    public OccuInsDetail $editing;
    public $occuIns;

    protected $queryString = [
        'occu_ins_id' => ['except' => '', 'as'=> 'id']
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

    public function getRowsQueryProperty()
    {
        $query =  OccuInsDetail::query()
            ->when($this->occu_ins_id, function ($query, $sid) {
                return $query->where('occu_ins_id', $sid);
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
