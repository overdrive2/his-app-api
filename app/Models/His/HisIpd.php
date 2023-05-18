<?php

namespace App\Models\His;

use App\Models\Officer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisIpd extends Model
{
    use HasFactory;

    public function getAdmOfficerIdAttribute()
    {
        return Officer::where('doctor_code', $this->admdoctor)->value('id');
    }
}
