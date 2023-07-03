<?php

namespace Database\Seeders;

use App\Models\OccuOpdStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccuOpdStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccuOpdStaff::truncate();

        $json = json_decode(file_get_contents("database/data/occu_opd_staff.json"), true);

        foreach ($json as $key => $value) {
            OccuOpdStaff::create([
                'id'   => $value['id'],
                'occu_staff_name' => $value['occu_staff_name'],
                'display_order' => $value['display_order'],
            ]);
        }
    }
}
