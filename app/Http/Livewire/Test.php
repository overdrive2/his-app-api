<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Test extends Component
{
    public $selected = ['2', '4'];

    public $options = [
        '1' => 'A',
        '2' => 'B',
        '3' => 'C',
        '4' => 'D',
        '5' => 'E',
    ];

    public function save()
    {
        dd(json_encode($this->selected));
    }

    public function render()
    {
        return view('livewire.test');
    }
}
