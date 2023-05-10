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

        $json = json_decode(file_get_contents("database/data/pttype_price_group.json"), true);

        foreach ($json as $key => $value) {
            PttypePriceGroup::create([
                "id"   => $value['id'],
                "name" => $value['name']
            ]);
        }
    }
}
