<?php

namespace App\Http\Livewire\NurseModule;

use Livewire\Component;

class NurseIpdList extends Component
{
    public $wardSelected = 3;
    public $wardName = 'Ward1';
    public $showEditModal = false;
    public function updatedwardSelected($val)
    {
        $this->wardName = ($val == '3') ? 'Ward3':'';
    }

    public function render()
    {
        return view('livewire.nurse-module.nurse-ipd-list');
    }
}
