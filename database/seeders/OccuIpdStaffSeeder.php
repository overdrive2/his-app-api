<?php

namespace Database\Seeders;

use App\Models\OccuIpdStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccuIpdStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccuIpdStaff::truncate();

        $json = json_decode(file_get_contents("database/data/occu_ipd_staff.json"), true);

        foreach ($json as $key => $value) {
            OccuIpdStaff::create([
                'id'   => $value['id'],
                'occu_staff_name' => $value['occu_staff_name'],
                'display_order' => $value['display_order'],
            ]);
        }
    }
}
