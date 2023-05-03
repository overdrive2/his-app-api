<?php

namespace Database\Seeders;

use App\Models\BedStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BedStatus::truncate();
  
        $csvFile = fopen(base_path("database/data/bed_statuses.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                BedStatus::create([
                    "id"              => $data['0'],
                    "bed_status_name" => $data['1'],
                    "is_available"    => $data['2']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
