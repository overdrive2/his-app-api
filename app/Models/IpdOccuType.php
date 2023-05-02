<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdOccuType extends Model
{
    use HasFactory;

    protected $fillable = ['ipd_occu_type_name'];
}