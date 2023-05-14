<?php

namespace App\Http\Livewire\NurseModule;

use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\IpdBedmove;
use Livewire\Component;

class NewcaseEntry extends Component
{
    use DateTimeHelpers;

    public $an;
    public $ipd;
    public $ward;

    protected $listeners = [
        'set:ipd' => 'setIpd'
    ];

    public IpdBedmove $editing;

    public function setIpd($val)
    {
        $this->an  = $val;
        $this->editing = $this->makeBlank();
    }

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.an' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.bed_id' => 'required',
            'editing.bedmove_type_id' => 'required',
            'editing.date_for_editing' => '',
        ];
    }

    public function makeBlank()
    {
        return IpdBedmove::make([
            'an' => $this->ipd->an ?? null,
            'bedmove_type_id' => config('ipd.newcase'),
            'movedate' => $this->getCurrentDate(),
            'movetime' => $this->getCurrentTime()
        ]);
    }

    public function mount()
    {
        $this->editing = $this->makeBlank();
    }

    public function save()
    {
        dd($this->editing);
    }

    public function render()
    {
        return view('livewire.nurse-module.newcase-entry');
    }
}
