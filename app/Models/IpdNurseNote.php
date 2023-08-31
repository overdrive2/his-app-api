<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'diag_id',
        'diag_date',
        'diag_time',
        'eva_result',
        'ipd_nurse_shift_id',
        'note_type_id',
        'note_type_desc',
        'ipd_bedmove_id',
        'severe_id',
        'spclty_id',
        'delflag',
        'created_by',
        'updated_by',
    ];
}
