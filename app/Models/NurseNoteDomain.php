<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'class_id',
        'class_ename',
        'class_tname'                        
    ];
}
