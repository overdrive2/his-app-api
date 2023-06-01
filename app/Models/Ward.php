<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ward_code', 'active'];

    public function getWaitRoomIdAttribute()
    {
        return Room::where('ward_id', $this->id)
            ->where('room_type_id', config('ipd.waitroom'))
            ->value('id');
    }
}
