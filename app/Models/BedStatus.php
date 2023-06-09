<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedStatus extends Model
{
    use HasFactory;

    protected $fillable = ['bed_status_name',	'is_available'];
}
