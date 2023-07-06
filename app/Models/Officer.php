<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_code',
        'officer_his_id',
        'fullname',
        'pname',
        'fname',
        'lname',
        'active',
        'licenseno',
        'cid',
        'position_id',
        'auto_lockout',
        'auto_lockout_minute',
    ];
}
