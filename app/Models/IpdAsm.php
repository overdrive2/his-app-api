<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdAsm extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_id',
        'asm_date',
        'asm_time',
        'ipd_asm_form_id',
        'ipd_nurse_shift_id'];
}
