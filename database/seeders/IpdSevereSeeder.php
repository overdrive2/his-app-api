<?php

namespace Database\Seeders;

use App\Models\IpdSevere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdSevereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdSevere::truncate();

        $json = json_decode(file_get_contents("database/data/ipd_severe.json"), true);

        foreach ($json as $key => $value) {
            IpdSevere::create([
                'id'   => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
