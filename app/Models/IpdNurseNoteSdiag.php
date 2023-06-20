<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdNurseNoteSdiag extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_nurse_note_id',
        'sdiag_id'
    ];
}
