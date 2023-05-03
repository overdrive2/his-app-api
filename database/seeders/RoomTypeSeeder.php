<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::truncate();
  
        $csvFile = fopen(base_path("database/data/room_types.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                RoomType::create([
                    "id"             => $data['0'],
                    "room_type_name" => $data['1']
                ]);
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
