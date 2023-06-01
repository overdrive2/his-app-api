<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWard extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ward_id'];
    protected $append = ['ward_name'];


    public function getWardNameAttribute()
    {
        return Ward::find($this->ward_id)->name;
    }
}
