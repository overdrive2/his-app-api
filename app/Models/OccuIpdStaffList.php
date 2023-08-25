<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccuIpdStaffList extends Model
{
    use HasFactory;

    protected $fillable = [
        'occu_ipd_id',
        'staff_id',
        'qty',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['staff_name'];

    public function getStaffNameAttribute()
    {
        return OccuIpdStaff::find($this->staff_id)
            ->occu_staff_name;
    }
}
