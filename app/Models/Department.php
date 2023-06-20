<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','depcode','active','detail','ward_id','phone','hospital_department_id','stock_department_id','display_order'];
    
}
