<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdFormAsmDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_form_asm_id',
        'web_label',
        'report_label',
        'input_type',
        'lookup_json',
        'have_other',
        'lookup_sql',
        'group_display',
        'sub_group_display',
        'display_order'      
    ];   

}
