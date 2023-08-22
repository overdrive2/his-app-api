<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdStaffList extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ipd_id',
        'staff_id',
        'value',
    ];
}
