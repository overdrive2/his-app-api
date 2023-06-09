<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_id',
        'ipd_id',
        'occu_ipd_type_id',
        'is_getout',
        'dch_type_id',
        'ipd_severe_type_id',
        'ipd_admit_type_id',
        'ipd_bedmove_id'                       
    ];
}
