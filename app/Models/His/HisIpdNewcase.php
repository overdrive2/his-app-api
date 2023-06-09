<?php

namespace App\Models\His;

use App\Helpers\FunctionDateTimes;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisIpdNewcase extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $connection = 'his';
    protected $table = 'his_ipd_newcase';

    protected $fillable = ['an', 'fullname', 'regdate', 'regtime', 'ward'];

    public function getRegDateThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->regdate));
    }

    public function getFullnameAttribute()
    {
        return $this->pname.$this->fname.' '.$this->lname;
    }

    public function getWardNameAttribute()
    {
        return Ward::where('ward_code', $this->ward)->value('name');
    }
}
