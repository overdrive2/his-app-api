<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\IpdFormAsm;
use Livewire\Component;

class AsmForm extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public IpdFormAsm $editing;

    public $search;
    public $form_id;

    protected $queryString = [
        'form_id' => ['except' => '', 'as' => 'id']
    ];

    public function rules()
    {
        return [
            'editing.asm_name' => 'required'
        ];
    }

    public function makeBlank()
    {
        return IpdFormAsm::make();
    }

    public function edit($id)
    {
        $this->editing = IpdFormAsm::find($id);
        $this->dispatchBrowserEvent('edmodal-show');
    }

    public function save()
    {
        $this->validate();
        $this->editing->save();
    }

    public function mount()
    {
        $this->editing = $this->makeBlank();
    }

    public function getRowsQueryProperty()
    {
        $query = IpdFormAsm::query()
            ->when($this->search, function($query, $search) {
                return $query->where('asm_name', 'like', $search.'%');
            });

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.admin.asm-form', [
            'rows' => $this->rows
        ]);
    }
}
