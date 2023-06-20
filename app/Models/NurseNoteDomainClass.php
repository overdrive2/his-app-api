<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteDomainClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_tname',
        'domain_ename'                     
    ];
}
