<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdRecord extends Model
{
    use HasFactory;
    
    protected $fillable = ['record_name', 'is_occu', 'display_order'];
}
