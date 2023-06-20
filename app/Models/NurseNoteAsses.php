<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteAsses extends Model
{
    use HasFactory;

    protected $fillable = [
        'asses_name',
        'unit',
        'icd10_id',
        'active',
        'link_type_id',
        'link_type_code'                        
    ];
}
