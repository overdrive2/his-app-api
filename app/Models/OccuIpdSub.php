<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdSub extends Model
{
    use HasFactory;

    protected $appends = ['ipd_admit_type_name'];

    protected $fillable = [
        'occu_ipd_id',
        'ipd_admit_type_id',
        'getin',
        'getnew',
        'getmove',
        'moveout',
        'discharge',
        'getout',
        'severe_1',
        'severe_2',
        'severe_3',
        'severe_4',
        'severe_5',
        'severe_6',
        'created_at',
        'updated_at',
    ];
}
