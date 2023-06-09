<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuOpdStaffList extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_id',
        'staff_id',
        'value',
    ];
}
