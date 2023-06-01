<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Seeder;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ward::truncate();

        $json = json_decode(file_get_contents("database/data/wards.json"), true);

        foreach ($json as $value) {
            Ward::create([
                'id'             => $value['id'],
                'name'           => $value['name'],
                'ward_code'      => $value['ward_code'],
                'active'         => $value['active']
            ]);
        }
    }
}
