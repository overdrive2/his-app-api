<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function beds()
    {
        return Bed::where('room_id', $this->id)
            ->orderBy('display_order')
            ->get();
    }
}
