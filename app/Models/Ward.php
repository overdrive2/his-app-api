<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ward_code', 'active','bedcount'];

    protected $appends = ['wait_bed_id'];

    public function getWaitBedIdAttribute()
    {
        return
            Bed::where('room_id',
                    Room::where('room_type_id', config('ipd.waitroom'))
                        ->where('ward_id', $this->id)
                        ->value('id')
                )->value('id');
    }

    public function getWaitRoomIdAttribute()
    {
        return Room::where('ward_id', $this->id)
            ->where('room_type_id', config('ipd.waitroom'))
            ->value('id');
    }

    public function rooms()
    {
        return Room::where('ward_id', $this->id)
            ->where('room_type_id', '<>', config('ipd.waitroom'))
            ->orderBy('display_order', 'asc')
            ->get();
    }
}
