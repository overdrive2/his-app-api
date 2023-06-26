<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdBedmove extends Model
{
    use HasFactory, FunctionDateTimes;

    protected $fillable = [
        'ipd_id',
        'an',
        'movedate',
        'movetime',
        'ward_id',
        'room_id',
        'bed_id',
        'bedmove_type_id',
        'created_by',
        'updated_by',
        'from_ref_id',
        'to_ref_id',
        'delflag'
    ];

    protected $appends = ['date_for_editing', 'time_for_editing', 'date_for_thai', 'ward_name', 'room_name', 'ipd'];

    protected static function boot()
    {
        parent::boot();

        self::saved(function($model){
            Ipd::where('id', $model->ipd_id)
                ->update([
                    'current_bedmove_id' => IpdBedmove::where('ipd_id', $model->ipd_id)
                        ->where('delflag', false)
                        ->orderBy('movedate', 'desc')
                        ->orderBy('movetime', 'desc')
                        ->value('id')
                ]);
            if($model->bedmove_type_id == config('ipd.moverecp')) {
                IpdBedmove::where('id', $model->from_ref_id)->update([
                    'to_ref_id' => $model->id
                ]);
            }
        });

    }

    public function getDateForThaiAttribute()
    {
        return $this->thai_date_short_number2(Carbon::parse($this->movedate));
    }

    public function getDateForEditingAttribute()
    {
        return Carbon::parse($this->movedate)->format('d/m/Y');
    }

    public function setDateForEditingAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $value);
        $this->movedate = $date->format('Y-m-d');
    }

    public function getTimeForEditingAttribute()
    {
        return Carbon::parse($this->movetime)->format('H:i');
    }

    public function setTimeForEditingAttribute($value)
    {
        $time = Carbon::createFromFormat('H:i',  $value);
        $this->movetime = $time->format('H:i');
    }

    public function getBedNameAttribute()
    {
        return Bed::where('id', $this->bed_id)->value('bed_name');
    }

    public function getWardNameAttribute()
    {
        return Ward::where('id', $this->ward_id)->value('name');
    }

    public function getRoomNameAttribute()
    {
        return Room::where('id', $this->room_id)->value('room_name');
    }

    public function getMovetypeNameAttribute()
    {
        return IpdBedmoveType::find($this->bedmove_type_id)->bedmove_type_name;
    }

    public function getIpdAttribute()
    {
        return Ipd::find($this->ipd_id);
    }

    public function ipd()
    {
        return Ipd::find($this->ipd_id);
    }
}
