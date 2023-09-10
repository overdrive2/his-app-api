<?php

namespace App\Http\Livewire\OccuIpd;

use App\Models\OccuIpdRecord;
use Livewire\Component;

class DetailRecord extends Component
{
    public $occu_ipd_id;
    public $saved = false;
    public $editing;
    public $cursor = '';
    public $edValue = 0;

    protected $listeners = [
        'detail-record:refresh' => '$refresh'
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
        if ($value > 100) return $this->dispatchBrowserEvent('swal:error',['text'=>'จำนวนไม่ถูกต้อง','title'=>'']);
        $this->editing->save();
        $this->cursor = '';
        $this->dispatchBrowserEvent('toastify');
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
