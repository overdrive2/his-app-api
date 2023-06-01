<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public $uid;
    public $user;

    protected $queryString = ['uid'];

    public function mount()
    {
        $this->user = User::find($this->uid);
    }

    public function render()
    {
        return view('livewire.admin.user-profile');
    }
}
