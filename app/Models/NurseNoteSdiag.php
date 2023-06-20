<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteSdiag extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdiag_name',
        'domain_class_id',
        'icd10_id',
        'active'                     
    ];
}
