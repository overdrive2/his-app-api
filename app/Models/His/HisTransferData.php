<?php

namespace App\Models\his;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HisTransferData extends Model
{
    use HasFactory;

    protected $connection = 'his';

    protected $fillable = ['code', 'pk_fieldname', 'value', 'created_by'];
}
