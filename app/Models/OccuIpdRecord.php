<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ipd_id',
        'ipd_record_id',
        'qty',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['record_name'];

    public function getRecordNameAttribute()
    {
        return IpdRecord::find($this->ipd_record_id)
            ->record_name;
    }
}
