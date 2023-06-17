<?php

namespace Database\Seeders;

use App\Models\NurseNoteIcd10;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseNoteIcd10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NurseNoteIcd10::truncate();

        $json = json_decode(file_get_contents("database/data/nurse_note_icd10s.json"), true);

        foreach ($json as $key => $value) {
            NurseNoteIcd10::create([
                'id'   => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
