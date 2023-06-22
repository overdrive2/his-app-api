<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuStaffList extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_id',
        'occu_type_id',
        'type_shift',
        'value'                    
    ];
}
