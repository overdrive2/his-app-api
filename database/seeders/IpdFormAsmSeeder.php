<?php

namespace Database\Seeders;

use App\Models\IpdFormAsm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpdFormAsmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IpdFormAsm::truncate();

        $json = json_decode(file_get_contents("database/data/ipd_form_asms.json"), true);

        foreach ($json as $key => $value) {
            IpdFormAsm::create([
                'id'   => $value['id'],
                'asm_name' => $value['asm_name'],
            ]);
        }
    }
}
