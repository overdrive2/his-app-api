<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteSpcltyList extends Model
{
    use HasFactory;

    protected $fillable = [
        'diag_id',
        'spclty_id'                    
    ];
}
