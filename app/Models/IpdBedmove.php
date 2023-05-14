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
        'bedmove_type_id'
    ];

    protected $appends = ['date_for_editing'];

    public function getDateForEditingAttribute()
    {
        return Carbon::parse($this->movedate)->format('d/m/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $value);
        $this->movedate = $date->format('Y-m-d');
    }
}
