<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdTypeList extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_dep_id',
        'occu_type_id',
        'display_order',
        'is_print',
    ];
}
