<?php

namespace Database\Seeders;

use App\Models\IpdOccuType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdOccuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdOccuType::truncate();
  
        $csvFile = fopen(base_path("database/data/ipd_occu_types.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                IpdOccuType::create([
                    "id"                 => $data['0'],
                    "ipd_occu_type_name" => $data['1']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
