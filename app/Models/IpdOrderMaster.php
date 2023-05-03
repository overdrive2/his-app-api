<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdOrderMaster extends Model
{
    use HasFactory;
    
    protected $fillable = ['hn', 'an', 'order_time', 'order_time'];
}
