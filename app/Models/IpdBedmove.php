<?php

namespace App\Models;

use App\Helpers\FunctionDateTimes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IpdBedmove extends Model
{
    use HasFactory, FunctionDateTimes, SoftDeletes;

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
        'delflag',
        'room_id',
        'moved_at',
    ];

    protected $appends = ['date_for_editing', 'an', 'time_for_editing', 'date_for_thai', 'ward_name', 'room_name', 'ipd'];

    /*protected static function boot()
    {
        parent::boot();

        self::saved(function($model) {
            if($model->from_ref_id) {
                $bedmove = IpdBedmove::find($model->from_ref_id);
                $bedmove->to_ref_id = $model->id;
                $bedmove->save();

                $lbm =  IpdBedmove::where('bed_id', $bedmove->bed_id)
                    ->where('delflag', false)
                    ->orderBy('movedate', 'desc')
                    ->orderBy('movetime', 'desc')
                    ->first();

                Bed::where('id', $bedmove->bed_id)
                    ->update([
                        'empty_flag' => (
                                ($lbm->bedmove_type_id == config('ipd.moveout'))
                                ||($lbm->to_ref_id != '0' && $lbm->to_ref_id != null)
                        )
                    ]);
            }

            $ipd = Ipd::find($model->ipd_id);
            // Update ipd current_bedmove_id
            $lbm = IpdBedmove::where('ipd_id', $model->ipd_id)
                ->where('delflag', false)
                ->where('to_ref_id', '0')
                ->orderBy('movedate', 'desc')
                ->orderBy('movetime', 'desc')
                ->first();

            $ipd->current_bedmove_id = $lbm->id;
            $ipd->save();

            if($model->bed_id > 0) {
                $bed = Bed::find($model->bed_id);
                $bed->last_bedmove_id = $model->id;
                $bed->empty_flag = ($model->bedmove_type_id == config('ipd.moveout'))
                    ||($lbm->to_ref_id != '0' && $lbm->to_ref_id != null);
                $bed->save();
            }

        });

    }*/

    public function getMoveIconAttribute()
    {
        $icon = match($this->bedmove_type_id){
            1 => 'text-lg text-green-500 fas fa-file-medical',
            2 => 'text-lg fas fa-people-arrows',
            3 => 'text-lg fas fa-compress-alt',
            4 => 'text-lg text-yellow-500 fas fa-retweet',
            default => '',
        };
        return $icon;
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
        $this->movedate = $value ? Carbon::createFromFormat('d/m/Y',  $value)->format('Y-m-d') : null;
    }

    public function getTimeForEditingAttribute()
    {
        return Carbon::parse($this->movetime)->format('H:i');
    }

    public function setTimeForEditingAttribute($value)
    {
        $this->movetime = $value ? Carbon::createFromFormat('H:i',  $value)->format('H:i') : null;
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

    public function getAnAttribute()
    {
        $ipd = Ipd::find($this->ipd_id);
        return $ipd ? $ipd->an : '';
    }

    public function ipd()
    {
        return Ipd::find($this->ipd_id);
    }

    public function getOccuIpdTypeAttribute()
    {
        return IpdBedmoveType::find($this->bedmove_type_id)->occu_ipd_type_id;
    }

    public function toRef()
    {
        return $this->to_ref_id ? IpdBedmove::find($this->to_ref_id) : null;
    }

    public function fromRef()
    {
        return $this->from_ref_id ? IpdBedmove::find($this->from_ref_id) : null;
    }
}
