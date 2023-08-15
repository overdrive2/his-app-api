<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\Traits\UserHelpers;
use Livewire\Component;

class Index extends Component
{
    use UserHelpers;

    public $tab = 1;

    protected $listeners = [
        'bmidx:refresh' => '$refresh',
    ];

    public function updatedTab()
    {
        //dd(config('menu.nurse.1'));
    }

    public function mount()
    {
      //  dd($this->user);
        //$this->ward_id = $this->user->current_ward_id;
    }

    public function render()
    {
        return view('livewire.nurse-module.index');
    }
}
