<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdRecordList extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ipd_id',
        'ipd_record_id',
        'started_at',
        'ended_at',
        'ipd_bedmove_id',
        'duration',
        'remark',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['date_for_editing', 'time_for_editing', 'date_for_thai', 'ward_name', 'room_name', 'ipd'];

    public function getRecordNameAttribute()
    {
        return IpdRecord::where('id', $this->ipd_record_id)->value('record_name');
    }

    public function getIpdAttribute()
    {
        return Ipd::find($this->ipd_id);
    }
}
