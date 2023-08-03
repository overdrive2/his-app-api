<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdBedmoveType extends Model
{
    use HasFactory;

    protected $fillable = ['bedmove_type_name', 'occu_ipd_type_id'];
}
