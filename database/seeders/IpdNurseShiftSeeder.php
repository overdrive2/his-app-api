<?php

namespace Database\Seeders;

use App\Models\IpdNurseShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdNurseShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdNurseShift::truncate();
  
        $csvFile = fopen(base_path("database/data/ipd_nurse_shifts.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                IpdNurseShift::create([
                    "id"               => $data['0'],
                    "nurse_shift_name" => $data['1'],
                    "stime"            => $data['2'],
                    "etime"            => $data['3'],
                    "display_order"    => $data['4']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
