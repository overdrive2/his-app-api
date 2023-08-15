<?php

namespace App\Http\Livewire\Test;

use Livewire\Component;

class Test extends Component
{
    public $date, $search;

    public function render()
    {
        return view('livewire.test.test');
    }
}
