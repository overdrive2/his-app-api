<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use App\Http\Livewire\Traits\DateTimeHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIns extends Model
{
    use HasFactory, DateTimeHelpers, FunctionDateTimes;

    protected $appends = ['occu_status_name', 'date_for_editing', 'time_for_editing', 'occu_ins_branch_name', 'ipd_nurse_shift_name'];

    protected $fillable = [
        'nurse_shift_date',
        'nurse_shift_time',
        'ipd_nurse_shift_id',
        'occu_status_id',
        'occu_ins_branch_id',
        'note',
        'reported_by',
        'reported_at',
        'reported',
        'approved_by',
        'approved_at',
        'approved',
        'line_noti',
        'updated_by',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function getOccuStatusNameAttribute()
    {
        $data = OccuStatus::find($this->occu_status_id);

        return $data ? $data->status_name : '';
    }

    public function getOccuInsBranchNameAttribute()
    {
        return OccuInsBranch::find($this->occu_ins_branch_id)
            ->branch_name;
    }

    public function getIpdNurseShiftNameAttribute()
    {
        $data = IpdNurseShift::find($this->ipd_nurse_shift_id);

        return $data ? $data->nurse_shift_name : '';
    }

    public function getUpdatedNameAttribute()
    {
        $data = Officer::select('fullname', 'licenseno')
            ->where('id', $this->updated_by)->first();

        return $data ? $data->fullname . '(' . $data->licenseno . ')' : '';
    }

    public function getCreatedNameAttribute()
    {
        $data = Officer::select('fullname', 'licenseno')
            ->where('id', $this->created_by)->first();

        return $data ? $data->fullname . '(' . $data->licenseno . ')' : '';
    }

    public function getDateForEditingAttribute()
    {
        return Carbon::parse($this->nurse_shift_date)->format('d/m/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $value);
        $this->nurse_shift_date = $date->format('Y-m-d');
    }

    public function getTimeForEditingAttribute()
    {
        return Carbon::parse($this->nurse_shift_time)->format('H:i');
    }

    public function setTimeForEditingAttribute($value)
    {
        $time = Carbon::createFromFormat('H:i',  $value);
        $this->nurse_shift_time = $time->format('H:i');
    }

    public function getDateForThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->nurse_shift_date));
    }
}
