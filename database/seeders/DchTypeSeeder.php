<?php

namespace Database\Seeders;

use App\Models\DchType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DchTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DchType::truncate();

        $json = json_decode(file_get_contents("database/data/dch_types.json"), true);

        foreach ($json as $key => $value) {
            DchType::create([
                "id"   => $value['id'],
                "name" => $value['name'],
                "code" => $value['code']
            ]);
        }
    }
}
