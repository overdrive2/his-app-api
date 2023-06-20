<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdSevereList extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'ipd_severe_id',
        'remark',
        'severe_start',
        'severe_end',
        'duration',
        'ward_id',
        'bed_id'                  
    ];
}
