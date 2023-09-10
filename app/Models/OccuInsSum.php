<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuInsSum extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ins_id',
        'max_ward_id',
        'max_qty1',
        'max_qty2',
        'max_s5_ward_id',
        'max_s5_qty1',
        'max_s5_qty2',
        'max_occu_ward_id',
        'max_occu_qty',
        'created_at',  
        'updated_at',  
    ];
}
