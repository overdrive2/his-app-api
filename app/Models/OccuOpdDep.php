<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdDep extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_group_dep_id',
        'occu_dep_name',
        'display_order',
    ];
}
