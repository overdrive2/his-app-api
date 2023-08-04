<?php

namespace App\Http\Livewire\OccuIpd;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\OccuIpd;
use App\Models\OccuIpdDetail;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Detail extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $occu_ipd_id;
    public OccuIpdDetail $editing;
    public $occuIpd;

    protected $queryString = [
        'occu_ipd_id' => ['except' => '', 'as'=> 'id']
    ];

    public function rules()
    {
        return [
            'editing.occu_ipd_id' => 'required',
            'editing.ipd_id' => 'required',
            'editing.occu_ipd_type_id' => 'required',
            'editing.is_getout' => '',
            'editing.ipd_bedmove_id' => '',
            'editing.updated_by' => '',
            'editing.created_by' => '',
        ];
    }

    public function makeBlank()
    {
        $userId = auth()->user()->id;

        return OccuIpdDetail::make([
            'occu_ipd_id' => $this->occu_ipd_id,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);
    }

    public function mount()
    {
        $this->occuIpd = OccuIpd::find($this->occu_ipd_id);
        $this->editing = $this->makeBlank();
    }

    public function edit($id)
    {
        $this->editing = OccuIpdDetail::find($id);
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipddetail-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipddetail-modal-show');
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

        $this->dispatchBrowserEvent('ipddetail-modal-close', [
            'msgstatus' => 'done',
        ]);
    }

    public function getRowsQueryProperty()
    {
        $query =  OccuIpdDetail::query()
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
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view(
            'livewire.occu-ipd.detail',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
