<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteIcd10 extends Model
{
    use HasFactory;

    protected $fillable = [
        'icd10_code',
        'icd10_name',
        'group_icd10_id'                     
    ];
}
