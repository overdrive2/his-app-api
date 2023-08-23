<?php

namespace App\Http\Livewire\OccuIpd;

use App\Models\OccuIpdRecord;
use App\Models\OccuIpdStaffList;
use Livewire\Component;

class DetailRecord extends Component
{
    public $occu_ipd_id;
    public $editing;
    public $cursor = '';
    public $edValue = 0;
    public $userId;

    protected $listeners = [
        'detail-staff:refresh' => '$refresh'
    ];
    public function rules()
    {
        return ['editing.qty' => 'required' ];
    }

    public function setCursor($id)
    {
        $this->editing = OccuIpdRecord::find($id);
        $this->cursor = $id;
        $this->emit('detail-record:refresh');

    }

    public function updatedEditing($value,$name)
    {        
        if ($value > 1000) return $this->dispatchBrowserEvent('swal:error',['text'=>'จำนวนไม่ถูกต้อง','title'=>'']);
        $this->editing->updated_by = $this->userId;
        $this->editing->save();
        $this->cursor = '';
        $this->dispatchBrowserEvent('toastify');
    }

    public function mount()
    {
        $this->userId = auth()->user()->id;
    }

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
