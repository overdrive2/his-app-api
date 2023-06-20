<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteLinkType extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_type_name',
        'link_type_var',
        'display_order'                        
    ];
}
