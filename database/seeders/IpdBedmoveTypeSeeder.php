<?php

namespace Database\Seeders;

use App\Models\IpdBedmoveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdBedmoveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdBedmoveType::truncate();

        $csvFile = fopen(base_path("database/data/ipd_bedmove_types.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                IpdBedmoveType::create([
                    "id"              => $data['0'],
                    "bedmove_type_name" => $data['1'],
                    "bedmove_type_available" => true,
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
