<?php
namespace App\Http\Livewire\Traits;

trait UserHelpers
{
    public $user;
    public $ward_id;

    public function updatedWardId($value)
    {
        if($this->user->current_ward_id != $value)
        {
            $this->user->current_ward_id = $value;
            $this->user->save();
        }
    }

    public function mountUserHelpers()
    {
        $this->user = auth()->user();
        $this->ward_id = $this->user->current_ward_id;
    }
}
