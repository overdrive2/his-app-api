<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteDiag extends Model
{
    use HasFactory;

    protected $fillable = [
        'diag_name',
        'diag_obj',
        'diag_keyword',
        'display_order',
        'icd10_id',
        'domain_class_id',
        'active',
        'auto_eva',
        'icd_on_subdx',
        'icd_on_asses',
        'icd_on_inter',
        'icd_on_subdx_count',
        'icd_on_asses_count',
        'icd_on_inter_count'                               
    ];
}
