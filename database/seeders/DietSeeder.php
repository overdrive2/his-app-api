<?php

namespace Database\Seeders;

use App\Models\Diet;
use Illuminate\Database\Seeder;
use File;

class DietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Diet::truncate();

        $json = json_decode(file_get_contents("database/data/ict_diets.json"), true);

        foreach ($json as $key => $value) {
            Diet::create([
                'id'             => $value['id'],
                'diet_name'      => $value['diet_name'],
                'cal'            => $value['cal'],
                'cho'            => $value['cho'],
                'protein'        => $value['protein'],
                'fat'            => $value['fat'],
                'other'          => $value['other'],
                'diet_type_id'   => $value['diet_type_id'],
                'diet_option_id' => $value['diet_option_id'],
                'display_order'  => $value['display_order'],
                'active'         => $value['active']
            ]);
        }
    }
}
