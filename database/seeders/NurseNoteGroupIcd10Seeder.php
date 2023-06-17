<?php

namespace Database\Seeders;

use App\Models\NurseNoteGroupIcd10;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseNoteGroupIcd10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NurseNoteGroupIcd10::truncate();

        $json = json_decode(file_get_contents("database/data/nurse_note_group_icd10s.json"), true);

        foreach ($json as $key => $value) {
            NurseNoteGroupIcd10::create([
                'id'   => $value['id'],
                'name' => $value['name'],
            ]);
        }
    }
}
