<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdDoctorList extends Model
{
    use HasFactory;

    protected $fillable = [
        'an',
        'officer_id',
        'ipd_doctor_type_id',
        'active',
        'remark',
        'incharge_date',
        'incharge_time',
        'finish_date',
        'finish_time'        
    ];
}
