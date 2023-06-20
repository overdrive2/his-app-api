<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseKardex extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'diag_id',
        'start_date',
        'finish_date',
        'note',
        'ipd_nurse_shift_id',
        'ipd_nurse_note_id',
        'bed_id',
        'spclty_id',
        'delflag'          
    ];
}
