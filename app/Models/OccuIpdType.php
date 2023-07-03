<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
    ];
}
