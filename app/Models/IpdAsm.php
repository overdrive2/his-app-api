<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdAsm extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $appends = ['date_for_editing', 'time_for_editing'];

    protected $fillable = [
        'ipd_id',
        'asm_date',
        'asm_time',
        'ipd_asm_form_id',
        'ipd_nurse_shift_id',
        'created_by',
        'updated_by',
        'saved'
    ];

    public function getDateForEditingAttribute()
    {
        return Carbon::parse($this->asm_date)->format('d/m/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y', $value);
        $this->asm_date = $date->format('Y-m-d');
    }

    public function getTimeForEditingAttribute()
    {
        return Carbon::parse($this->asm_time)->format('H:i');
    }

    public function getTypeNameAttribute()
    {
        return IpdNurseShift::find($this->ipd_nurse_shift_id)->nurse_shift_name;
    }

    public function setTimeForEditingAttribute($value)
    {
        $time = Carbon::createFromFormat('H:i', $value);
        $this->asm_time = $time->format('H:i');
    }

    public function getCreateByNameAttribute()
    {
        return User::where('id', $this->created_by)->value('name');
    }

    public function getUpdateByNameAttribute()
    {
        return User::where('id', $this->updated_by)->value('name');
    }
}
