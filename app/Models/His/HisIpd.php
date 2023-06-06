<?php

namespace App\Models\His;

use App\Models\DchStatus;
use App\Models\DchType;
use App\Models\Officer;
use App\Models\Pttype;
use App\Models\Spclty;
use App\Models\Ward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisIpd extends Model
{
    use HasFactory;

    protected $connection = 'his';
    protected $table  = 'ipt';

    public function getAdmOfficerIdAttribute()
    {
        return Officer::where('doctor_code', $this->admdoctor)->value('id');
    }

    public function getDchStatusIdAttribute()
    {
        return DchStatus::where('code', $this->dchstts)->value('id');
    }

    public function getDchTypsIdAttribute()
    {
        return DchType::where('code', $this->dchtype)->value('id');
    }

    public function getDchOfficerIdAttribute()
    {
        return Officer::where('doctor_code', $this->dch_doctor)->value('id');
    }

    public function getFirstWardIdAttribute()
    {
        return Ward::where('ward_code', $this->first_ward)->value('id');
    }

    public function getPttypeIdAttribute()
    {
        return Pttype::where('pttype_code', $this->pttype)->value('id');
    }

    public function getSpcltyIdAttribute()
    {
        return Spclty::where('spclty_code', $this->spclty)->value('id');
    }
}
