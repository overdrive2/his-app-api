<?php

namespace Database\Seeders;

use App\Models\NurseNoteDomainClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseNoteDomainClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NurseNoteDomainClass::truncate();

        $json = json_decode(file_get_contents("database/data/nurse_note_domain_classes.json"), true);

        foreach ($json as $key => $value) {
            NurseNoteDomainClass::create([
                'id'   => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
