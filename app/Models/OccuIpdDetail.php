<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdDetail extends Model
{
    use HasFactory;

    protected $appends = ['occu_ipd_type_name', 'an'];

    protected $fillable = [
        'occu_ipd_id',
        'ipd_id',
        'occu_ipd_type_id',
        'is_getout',
        'ipd_bedmove_id'                       
    ];

    public function getOccuIpdTypeNameAttribute()
    {
        $data = OccuIpdType::find($this->occu_ipd_type_id);
    
        return $data ? $data->type_name : '';
    } 

    public function getAnAttribute()
    {
        $data = Ipd::find($this->ipd_id);
    
        return $data ? $data->an : '';

        $data = Ipd::select('an','hn','ward_id')->where('id',$this->ipd_id)->first();

    } 

    public function bedmove()
    {        
        return $this->ipd_bedmove_id ? IpdBedmove::find($this->ipd_bedmove_id) : [];
    } 
}
