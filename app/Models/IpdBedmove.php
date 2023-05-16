<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdBedmove extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'an',
        'movedate',
        'movetime',
        'bed_id',
        'bedmove_type_id',
        'created_by',
        'updated_by'
    ];

    protected $appends = ['date_for_editing', 'time_for_editing'];

    public function getDateForEditingAttribute()
    {
        return Carbon::parse($this->movedate)->format('d/m/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $value);
        $this->movedate = $date->format('Y-m-d');
    }

    public function getTimeForEditingAttribute()
    {
        return Carbon::parse($this->movetime)->format('H:i');
    }

    public function setTimeForEditingAttribute($value)
    {
        $time = Carbon::createFromFormat('H:i',  $value);
        $this->movetime = $time->format('H:i');
    }
}
