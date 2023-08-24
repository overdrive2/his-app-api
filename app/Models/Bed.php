<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;
    protected $fillable = ['bed_name', 'bed_code', 'room_id', 'bed_status_id', 'display_order', 'last_bedmove_id', 'empty_flag'];
    protected $appends = ['ipd'];

    public function lastBedmove()
    {
        return IpdBedmove::where('bed_id', $this->id)
            ->where('delflag', false)
            ->orderBy('movedate', 'desc')
            ->orderBy('movetime', 'desc')
            ->first();
       // return $val ? $val : null;
    }

    public function bedmove()
    {
        return $this->last_bedmove_id ? IpdBedmove::find($this->last_bedmove_id) : null;
    }

    public function getIpdAttribute()
    {
        $lbmId = $this->last_bedmove_id;
        return
            $lbmId ? Ipd::select('id', 'an', 'patient_id', 'current_bedmove_id')
            ->where('current_bedmove_id', $lbmId)
            ->first() : null;
    }
}
