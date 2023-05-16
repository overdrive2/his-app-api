<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\FunctionDateTimes;

class HisIpdNewcase extends Model
{
    use HasFactory, FunctionDateTimes;

    public function getFullnameAttribute()
    {
        return $this->pname.$this->fname.' '.$this->lname;
    }

    public function getRegDateThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->regdate));
    }

    public function getWardNameAttribute()
    {
        return Ward::where('wardcode', $this->ward)->value('name');
    }
}
