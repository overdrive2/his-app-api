<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_shift_date',
        'nurse_shift_time',
        'occu_dep_id',
        'occu_status_id',
        'ipd_nurse_shift_id',
        'note',
    ];
}
