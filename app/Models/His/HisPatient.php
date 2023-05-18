<?php

namespace App\Models\His;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisPatient extends Model
{
    use HasFactory;

    protected $connection = 'his';
}
