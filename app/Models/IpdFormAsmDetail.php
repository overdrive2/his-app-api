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
        'display_order',
        'colspan',
        'ipd_form_section_id'
    ];

    protected $appends = ['asm_detail', 'json_data', 'section_name'];

    public function getAsmDetailAttribute()
    {
        return $this->where('parent_id', $this->id)
            ->where('input_type', '<>', 'PARENT')
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function getSectionNameAttribute()
    {
        return IpdFormSection::where('id', $this->ipd_form_section_id)->value('name');
    }

    public function getJsonDataAttribute()
    {
        return $this->lookup_json ? json_decode($this->lookup_json) : [];
    }

    public function setJsonDataAttribute($value)
    {
        $this->lookup_json = json_encode($value);
    }
}
