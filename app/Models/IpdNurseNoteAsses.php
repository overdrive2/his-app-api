<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseNoteAsses extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_nurse_note_id',
        'asses_id',
        'asses_value',
        'count_on_icd'
    ];
}
