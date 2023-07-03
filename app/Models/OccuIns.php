<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIns extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_shift_date',
        'nurse_shift_time',
        'ipd_nurse_shift_id',
        'occu_status_id',
        'occu_ins_branch_id',
        'note',
        'reported_by',
        'reported_at',
        'reported',
        'approved_by',
        'approved_at',
        'approved',
        'line_noti'                      
    ];
}
