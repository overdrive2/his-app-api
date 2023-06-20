<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseNoteIcd10 extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_nurse_note_id',
        'icd10_id',
    ];
}
