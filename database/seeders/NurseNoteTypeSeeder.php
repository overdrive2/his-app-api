<?php

namespace Database\Seeders;

use App\Models\NurseNoteType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseNoteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NurseNoteType::truncate();

        $json = json_decode(file_get_contents("database/data/nurse_note_types.json"), true);

        foreach ($json as $key => $value) {
            NurseNoteType::create([
                'id'   => $value['id'],
                'note_type_name' => $value['note_type_name'],
                'display_order' => $value['display_order'],
            ]);
        }
    }
}
