<?php

namespace Database\Seeders;

use App\Models\DrugItem;
use App\Models\IpdFormAsm;
use Illuminate\Database\Seeder;

class DrugItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DrugItem::truncate();

        $json = json_decode(file_get_contents("database/data/ict_drug_items.json"), true);

        foreach ($json as $key => $value) {
            DrugItem::create([
                'id' => $value['id'],
                'icode' => $value['icode'],
                'iname' => $value['iname'],
                'medtype' => $value['medtype'],
                'created_by' => $value['created_by'],
                'updated_by' => $value['updated_by'],
                'stg' => $value['stg'],
                'dispense_dose' => $value['dispense_dose'],
                'usage_unit_code' => $value['usage_unit_code'],
                "hide_dose" => $value['hide_dose'],
                "medtype_list" => $value['medtype_list'],
                "active" => $value['active'],
                "ict_stock_department_id" => $value['ict_stock_department_id'],
                "ict_drug_national_id" => $value['ict_drug_national_id']
            ]);
        }
    }
}
