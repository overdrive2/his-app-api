<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdAsmDetail extends Model
{
    use HasFactory;

    protected $fillable = ['ipd_asm_id', 'ipd_form_asm_detail_id', 'asm_value'];
}