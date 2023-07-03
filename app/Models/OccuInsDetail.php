<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuInsDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ins_id',
        'occu_ins_event',
        'occu_ins_solve'            
    ];
}
