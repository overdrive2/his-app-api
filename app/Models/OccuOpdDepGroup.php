<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdDepGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_dep_group_name',
        'sql_command',
    ];
}
