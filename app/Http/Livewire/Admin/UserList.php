<?php

namespace App\Http\Livewire\Admin;

use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    use WithCachedRows, WithPerPagePagination;

    public function getRowsQueryProperty()
    {
        return User::query();
    }

    public function getRowsProperty()
    {
        return $this->cache(function(){
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.admin.user-list',[
            'rows' => $this->rows
        ]);
    }
}
