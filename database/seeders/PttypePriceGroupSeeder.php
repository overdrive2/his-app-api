<?php

namespace Database\Seeders;

use App\Models\PttypePriceGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PttypePriceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PttypePriceGroup::truncate();
  
        $csvFile = fopen(base_path("database/data/pttype_price_group.json"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                PttypePriceGroup::create([
                    "id"              => $data['0'],
                    "name" => $data['1']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
