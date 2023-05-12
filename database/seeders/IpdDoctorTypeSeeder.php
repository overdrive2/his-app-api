<?php

namespace Database\Seeders;

use App\Models\IpdDoctorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdDoctorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdDoctorType::truncate();

        $json = json_decode(file_get_contents("database/data/ipd_doctor_type.json"), true);

        foreach ($json as $key => $value) {
            IpdDoctorType::create([
                'id'   => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
