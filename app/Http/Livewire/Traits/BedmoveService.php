<?php

namespace App\Http\Livewire\Traits;

use App\Models\IpdBedmove;
use App\Models\Room;

trait BedmoveService
{
    use DateTimeHelpers;

    public IpdBedmove $editing;

    public $selectedId;

    public $ipd = [
        'an' => '',
        'hn' => '',
        'fullname' => ''
    ];

    public function rules()
    {
        return [
            'editing.ipd_id' => 'required',
            'editing.ref_id' => '',
            'editing.ward_id' => 'required',
            'editing.movedate' => 'required',
            'editing.movetime' => 'required',
            'editing.bedmove_type_id' => 'required',
            'editing.bed_id' => 'required_if:editing.bedmove_type_id,=,'.config('ipd.moveself'),
            'editing.updated_by' => 'required',
            'editing.created_by' => 'required',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
            'editing.delflag' => 'required'
        ];
    }

    public function makeBlank()
    {
        $uid = auth()->user()->id;

        return IpdBedmove::make([
            'bed_id' => 0,
            'ref_id' => 0,
            'ward_id' => $this->ward_id,
            'updated_by' => $uid,
            'created_by' => $uid,
            'movetime' => $this->getCurrentTime(),
            'bedmove_type_id' => config('ipd.moveself'),
            'delflag' => false
           ]);
    }

    public function mountBedmoveService()
    {
        $this->editing = $this->makeBlank();
    }

    public function updatedWardId($value)
    {
        $rooms = Room::where('ward_id', $value)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->get();

        $this->editing->bedmove_type_id = ($this->ward_id == $this->current_ward_id) ? config('ipd.moveself') : config('ipd.moveout');
        $this->editing->bed_id = ($this->editing->bedmove_type_id == config('ipd.moveout')) ? null : $this->editing->bed_id;

        $this->dispatchBrowserEvent('rooms-update', [
            'rooms' => $rooms,
        ]);
    }

    public function editMove($id)
    {
        $this->editing = IpdBedmove::find($id);

        $this->ward_id = $this->editing->ward_id;
        $this->current_ward_id = $this->editing->ward_id;

        $ipd = $this->editing->ipd();

        $this->dispatchBrowserEvent('modal-show', [
            'ipd' => [
                'an' => $ipd->an,
                'hn' => $ipd->hn,
                'fullname' => $ipd->patient_name,
            ],
            'wards' => $this->user->wards(),
            'rooms' => $this->updatedWardId($this->ward_id),
        ]);
    }

    public function delete()
    {
        $bedmove = IpdBedmove::find($this->selectedId);
        return $bedmove->delete();
    }

}
