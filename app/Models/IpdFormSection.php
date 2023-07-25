<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdFormSection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'ipd_form_asm_id','col','parent_id', 'display_order', 'updated_by', 'created_by'];
}
