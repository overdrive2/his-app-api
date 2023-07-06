<?php

namespace App\Http\Livewire\NurseInspector;

use App\Http\Livewire\Traits\DateTimeHelpers;
use Livewire\Component;

class Detail extends Component
{
    use DateTimeHelpers;

    public $occu_ins_id;

    protected $queryString = [
        'occu_ins_id' => ['except' => '', 'as'=> 'id']
    ];

    public function render()
    {
        return view('livewire.nurse-inspector.detail');
    }

    
}
