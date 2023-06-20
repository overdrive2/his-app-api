<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteGroupIcd10 extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_tname',
        'group_ename'                     
    ];
}
