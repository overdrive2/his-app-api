<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'hn',
        'pname',
        'fname',
        'lname',
        'cid',
        'birthday',
        'sex',
        'is_death',
        'mobile_phone_number',
        'is_admit',
        'updated_by',
        'created_by'
    ];
}
