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
    public $delId;
    public $userId;

    protected $listeners = [
        'delete:occu-ipd-detail'=>'delete',
        'confirm:commit'=>'commit'];

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
        return OccuIpdDetail::make([
            'occu_ipd_id' => $this->occu_ipd_id,
            'created_by' => $this->userId,
            'updated_by' => $this->userId,
        ]);
    }

    public function mount()
    {
        $this->userId = auth()->user()->id;
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

    public function deleteConfirm($id)
    {     
        $this->delId = $id;
        $this->dispatchBrowserEvent('delete:confirm', [
            'action' => 'delete:occu-ipd-detail',
        ]);
    } 

    public function delete()
    {        
        //$this->delId
        $occu_ipd_detail = OccuIpdDetail::find($this->delId);
        $occu_ipd_detail->delete();
        
        $this->dispatchBrowserEvent('toastify');    
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
        //update main
        $i_type1 = 0;
        $i_type2 = 0;
        $i_type3 = 0;
        $i_type4 = 0;
        $i_type5 = 0;
        $i_type6 = 0;
        $occu_ipd_detail = OccuIpdDetail::where('occu_ipd_id', $this->occu_ipd_id)->orderBy('id','asc');
        $occu = $occu_ipd_detail->get();

        foreach ($occu as $occu_row) {
            if ($occu_row->occu_ipd_type_id == 1) { $i_type1++; }
            else if ($occu_row->occu_ipd_type_id == 2) { $i_type2++; }
            else if ($occu_row->occu_ipd_type_id == 3) { $i_type3++; }
            else if ($occu_row->occu_ipd_type_id == 4) { $i_type4++; }
            else if ($occu_row->occu_ipd_type_id == 5) { $i_type5++; }
            else if ($occu_row->occu_ipd_type_id == 6) { $i_type6++; }
        }

        OccuIpd::find($this->occu_ipd_id)->orderBy('id','asc')->update([
            'getin' => $i_type1,
            'getnew' => $i_type2,
            'getmove' => $i_type3,
            'moveout' => $i_type4,
            'discharge' => $i_type5,
            'getout' => $i_type6,
            'updated_by' => $this->userId,
            'saved' => true,
        ]);

        //update detail
        $occu_ipd_detail->update(['saved' => true]);
        $this->redirect(route('occu.ipd'));
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
