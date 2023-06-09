<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteInterList extends Model
{
    use HasFactory;

    protected $fillable = [
        'diag_id',
        'inter_id',
        'icd_on_inter',
        'display_order'                        
    ];
}
