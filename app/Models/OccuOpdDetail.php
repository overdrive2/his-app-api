<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_id',
        'occu_opd_type_id',
        'value',
    ];
}
