<?php

namespace App\Http\Livewire\Admin;

use App\Models\UserWard;
use App\Models\Ward;
use Livewire\Component;

class UserWards extends Component
{
    public $uid, $wards, $search_ward;

    protected $listeners = [
        'select:ward' => 'selectWard'
    ];

    public function selectWard($id)
    {
        $uid = auth()->user();

        UserWard::create([
            'user_id' => $this->uid,
            'ward_id' => $id,
            'created_by' => $uid,
            'updated_by' => $uid,
        ]);

        $this->dispatchBrowserEvent('hide-modal', ['status' => 200]);
    }

    public function mount()
    {
        $this->wards = $this->getRow();
    }

    public function getRow()
    {
        return
            Ward::where('active', true)
                ->when($this->search_ward, function($query, $kw){
                    return $query->whereRaw("name like '%".$kw."%'");
            })->get();
    }

    public function updatedSearchWard()
    {
        $wards = $this->getRow();
        $this->dispatchBrowserEvent('set-wards', [
            'wards' => $wards,
        ]);
    }

    public function getRowsProperty()
    {
        return UserWard::where('user_id', $this->uid)->get();
    }

    public function render()
    {
        return view('livewire.admin.user-wards', [
            'rows' => $this->rows
        ]);
    }
}
