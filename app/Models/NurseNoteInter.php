<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteInter extends Model
{
    use HasFactory;

    protected $fillable = [
        'inter_name',
        'unit',
        'icd10_id',
        'active',
        'link_type_id',
        'link_type_code'                        
    ];
}
