<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'display_order',
    ];
}
