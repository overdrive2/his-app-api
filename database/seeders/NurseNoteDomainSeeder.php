<?php

namespace Database\Seeders;

use App\Models\NurseNoteDomain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseNoteDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NurseNoteDomain::truncate();

        $json = json_decode(file_get_contents("database/data/nurse_note_domains.json"), true);

        foreach ($json as $key => $value) {
            NurseNoteDomain::create([
                'id'   => $value['id'],
                'domain_tname' => $value['domain_tname'],
                'domain_ename' => $value['domain_ename'],
            ]);
        }
    }
}
