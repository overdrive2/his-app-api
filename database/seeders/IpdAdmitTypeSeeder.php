<?php

namespace Database\Seeders;

use App\Models\IpdAdmitType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdAdmitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdAdmitType::truncate();

        $json = json_decode(file_get_contents("database/data/ipd_admit_type.json"), true);

        foreach ($json as $key => $value) {
            IpdAdmitType::create([
                "id"   => $value['id'],
                "name" => $value['name']
            ]);
        }
    }
}
