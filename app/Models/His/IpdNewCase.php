<?php

namespace App\Models\His;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNewCase extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $connection = 'his';
    protected $table = 'his_ipd_newcase';

    public function getFullnameAttribute()
    {
        return $this->pname.$this->fname.' '.$this->lname;
    }

    public function getRegDateThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->regdate));
    }
}
