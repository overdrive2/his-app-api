<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugItem extends Model
{
    use HasFactory;

    protected $fillable = ['icode',	'iname',	'medtype',	'created_by',	'updated_by',	'stg',	'dispense_dose',	'usage_unit_code',	'hide_dose',	'medtype_list',	'active',	'ict_stock_department_id',	'ict_drug_national_id'];
}
