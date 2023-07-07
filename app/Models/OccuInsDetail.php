<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuInsDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ins_id',
        'occu_ins_event',
        'occu_ins_solve',
        'updated_by',
        'created_by',
        'created_at',
        'updated_at',        
    ];

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
}
