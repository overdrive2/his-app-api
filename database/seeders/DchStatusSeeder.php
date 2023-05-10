<?php

namespace Database\Seeders;

use App\Models\DchStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DchStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DchStatus::truncate();

        $json = json_decode(file_get_contents("database/data/dch_statuses.json"), true);

        foreach ($json as $key => $value) {
            DchStatus::create([
                "id"   => $value['0'],
                "name" => $value['1'],
                "code" => $value['2']
            ]);
        }
    }
}
