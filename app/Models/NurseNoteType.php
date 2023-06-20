<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteType extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_type_name',
        'display_order'                    
    ];
}
