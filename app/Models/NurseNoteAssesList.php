<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteAssesList extends Model
{
    use HasFactory;

    protected $fillable = [
        'diag_id',
        'asses_id',
        'icd_on_asses',
        'display_order'                        
    ];
}
