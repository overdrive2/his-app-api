<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdOccu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_shift_date',
        'ward_id',
        'getin',
        'getnew',
        'getmove',
        'moveout',
        'discharge',
        'getout',
        'occu_status_id',
        'note',
        'ipd_nurse_shift_id',
        'severe_1',
        'severe_2',
        'severe_3',
        'severe_4',
        'severe_5',
        'severe_6',
    ];
}
