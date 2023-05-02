<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuStaff extends Model
{
    use HasFactory;

    protected $fillable = ['occu_staff_name','type_shift','display_order'];
}