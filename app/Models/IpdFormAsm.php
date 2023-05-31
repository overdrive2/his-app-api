<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdFormAsm extends Model
{
    use HasFactory;

    protected $fillable = ['asm_name'];
}
