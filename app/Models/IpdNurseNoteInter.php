<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseNoteInter extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_nurse_note_id',
        'inter_id',
        'inter_value',
        'count_on_icd'
    ];
}
