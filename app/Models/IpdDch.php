<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdDch extends Model
{
    use HasFactory;    
    
    protected $fillable = [
        'ipd_id',
        'confirm_discharge',
        'dchdate',
        'dchtime',
        'dch_status_id',
        'dch_type_id',
        'dch_officer_id',
        'dch_ipd_severe_id',
        'dch_spclty_id',
        'los',
        'sdx1',
        'sdx2',
        'confirm_summary_dc',
        'summary_dc_officer_id',
        'plan',
        'operation',
        'created_by',
        'updated_by',
    ];
}
