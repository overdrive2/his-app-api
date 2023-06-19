<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;
    protected $fillable = ['bed_name', 'bed_code', 'room_id', 'bed_status_id', 'display_order'];
    protected $appends = ['ipd'];

    public function getLastBedmoveIdAttribute()
    {
        $val = IpdBedmove::where('bed_id', $this->id)
            ->orderBy('movedate', 'desc')
            ->orderBy('movetime', 'desc')
            ->value('id');
        return $val ? $val : null;
    }

    public function getIpdAttribute()
    {
        return
            $this->last_bedmove_id ? Ipd::select('id', 'an', 'patient_id', 'current_bedmove_id')
            ->where('current_bedmove_id', $this->last_bedmove_id)
            ->first() : [];
    }
}
