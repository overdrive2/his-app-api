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
        'parent_id',
        'display_order'
    ];

    protected $append = ['asm_detail', 'json_data'];

    public function getAsmDetailAttribute()
    {
        return $this->where('parent_id', $this->id)
            ->where('input_type', '<>', 'PARENT')
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function getJsonDataAttribute()
    {
        return json_decode($this->lookup_json);
    }
}
