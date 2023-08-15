<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\DrugItem;
use Livewire\Component;

class DrugItems extends Component
{
    use WithPerPagePagination, WithCachedRows;
    public $active = true;
    public $editing;
    public $search;
    public $date;

    public function rules()
    {
        return [
            'editing.icode' => 'required',
            'editing.iname' => 'required',
            'editing.medtype' => 'required',
            'editing.created_by' => 'required',
            'editing.updated_by' => 'required',
            'editing.stg' => '',
            'editing.dispense_dose' => '',
            'editing.usage_unit_code' => '',
            'editing.hide_dose' => '',
            'editing.medtype_list' => '',
            'editing.active' => '',
            'editing.ict_stock_department_id' => '',
            'editing.ict_drug_national_id' => '',
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;
        return DrugItem::make([
            'created_by' => $uid,
            'updated_by' => $uid,
        ]);
    }

    public function edit($id)
    {
        $this->editing = DrugItem::find($id);
    }

    public function getRowsQueryProperty()
    {
        return DrugItem::query()
            ->when($this->active, function($query){
                return $query->where('active', true);
            })
            ->when($this->search, function($query, $search){
                return $query->where('iname', 'like', '%'.$search.'%');
            })
            ->orderBy('medtype', 'asc')
            ->orderBy('iname', 'asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function mount()
    {
        $this->editing = $this->makeBlank();
    }

    public function save()
    {
        $this->editing->save();
        $this->dispatchBrowserEvent('close-mdmodal');
    }

    public function render()
    {
        return view('livewire.admin.drug-items',[
            'rows' => $this->rows
        ])->layout('layouts.admin');
    }
}
