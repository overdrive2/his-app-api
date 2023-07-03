<?php

namespace Database\Seeders;

use App\Models\OccuIpdType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccuIpdTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OccuIpdType::truncate();

        $json = json_decode(file_get_contents("database/data/occu_ipd_types.json"), true);

        foreach ($json as $key => $value) {
            OccuIpdType::create([
                'id'   => $value['id'],
                'type_name' => $value['type_name'],
            ]);
        }
    }
}
