<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NurseNoteSdiagList extends Model
{
    use HasFactory;

    protected $fillable = [
        'diag_id',
        'sdiag_id',
        'icd_on_sdiag',
        'display_order'                        
    ];
}
