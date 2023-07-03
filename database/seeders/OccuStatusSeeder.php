<?php

namespace Database\Seeders;

use App\Models\OccuStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccuStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccuStatus::truncate();
  
        $csvFile = fopen(base_path("database/data/occu_statuses.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                OccuStatus::create([
                    "id"               => $data['0'],
                    "status_name" => $data['1']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
