<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'diet_name',
        'cal',
        'cho',
        'protein',
        'fat',
        'other',
        'diet_type_id',
        'diet_option_id',
        'display_order',
        'active'
    ];
}
