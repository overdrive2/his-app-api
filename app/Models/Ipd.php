<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipd extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $fillable = [
        'an',
        'vn',
        'adm_officer_id',
        'regdate',
        'regtime',
        'spclty_id',
        'firstward_id',
        'pttype_id',
        'ipd_severe_id',
        'ipd_admit_type_id',
        'admit_for',
        'drainages',
        'line_noty',
        'is_screen_asses',
        'is_vs_new',
        'is_do_med',
        'is_nn_new',
        'reasonadmit_type_id',
        'o2_type_id',
        'occu_type_id',
        'created_by',
        'updated_by',
        'patient_id',
        'current_bedmove_id'
    ];

    protected $appends = ['hn', 'regdate_for_thai', 'ward_name', 'patient_name',
        'current_bedmove_name'
    ];

    public function getCurrentBedmoveNameAttribute()
    {
        $str = '';
        if($this->current_bedmove_id) {
            $row = IpdBedmove::find($this->current_bedmove_id);
            $str = $row?->bed_name;
        }
        return $str;
    }

    public function getWardNameAttribute()
    {
        return Ward::find($this->ward_id)->name ?? '';
    }

    public function getRegdateForThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->regdate));
    }

    public function getPatientNameAttribute()
    {
        $str = '';

        if($this->patient_id) {
            $row = Patient::select('pname', 'fname', 'lname')
                ->where('id', $this->patient_id)->first();
            $str = $row->pname.$row->fname.' '.$row->lname;
        }

        return $str;
    }

    public function getHnAttribute()
    {
        return Patient::find($this->patient_id)->hn;
    }

    public function lastBed()
    {
        return IpdBedmove::where('ipd_id', $this->id)
            ->orderBy('movedate', 'desc')
            ->orderBy('movetime', 'desc')
            ->first();
    }

    public function bedmoves()
    {
        return  IpdBedmove::where('ipd_id', $this->id)
            ->orderBy('movedate', 'asc')
            ->orderBy('movetime', 'asc')
            ->get();
    }
}
