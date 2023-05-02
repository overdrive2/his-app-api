<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OccuStatus extends Model
{
    use HasFactory;

    protected $fillable = ['occu_status_name'];
}