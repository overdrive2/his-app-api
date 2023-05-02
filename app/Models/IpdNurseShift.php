<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseShift extends Model
{
    use HasFactory;

    protected $fillable = ['nurse_shift_name',	'stime',	'etime',	'display_order'];
}
