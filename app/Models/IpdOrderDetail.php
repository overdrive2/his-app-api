<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipd_order_master_id',
        'order_type_id',
        'order_subtype_id',
        'multi_subtype_id',
        'off_date',
        'off_time',
        'order_type',
        'other',
        'off_by',
        'off_confirn_by',
        'closed',
        'ipd_order_template_detail_id',
        'pre_order',
        'pre_order_date',
        'pre_order_time',
        'ref_ids',
        'ref_on_ids'            
    ];
}
