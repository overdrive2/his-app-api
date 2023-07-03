<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_staff_name',
        'display_order',
    ];
}
