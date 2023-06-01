<?php

namespace Database\Seeders;

use App\Models\IpdFormAsmDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdFormAsmDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdFormAsmDetail::truncate();

        $json = json_decode(file_get_contents("database/data/ipd_form_asm_details.json"), true);

        foreach ($json as $key => $value) {
            IpdFormAsmDetail::create([
                'id'   => $value['id'],
                'ipd_form_asm_id' => $value['ipd_form_asm_id'],
                'web_label' => $value['web_label'],
                'report_label' => $value['report_label'],
                'input_type' => $value['input_type'],
                'have_other' => $value['have_other'],
                'lookup_sql' => $value['lookup_sql'],
                'group_display' => $value['group_display'],
                'sub_group_display' => $value['sub_group_display'],
                'display' => $value['display'],
            ]);
        }
    }
}
