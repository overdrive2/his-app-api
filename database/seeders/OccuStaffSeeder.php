<?php

namespace Database\Seeders;

use App\Models\OccuStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccuStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccuStaff::truncate();
  
        $csvFile = fopen(base_path("database/data/occu_staffs.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                OccuStaff::create([
                    "id"              => $data['0'],
                    "occu_staff_name" => $data['1'],
                    "type_shift"      => $data['2'],
                    "display_order"   => $data['3']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
