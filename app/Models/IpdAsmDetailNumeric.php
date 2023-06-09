<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdAsmDetailNumeric extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_asm_id',
        'ipd_form_asm_id',
        'value'];
}
