<?php

namespace Database\Seeders;

use App\Models\Bed;
use Illuminate\Database\Seeder;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bed::truncate();

        $json = json_decode(file_get_contents("database/data/beds.json"), true);

        foreach ($json as $value) {
            Bed::create([
                'id'             => $value['id'],
                'bed_name'           => $value['bed_name'],
                'bed_code'      => $value['bed_code'],
                'room_id'      => $value['room_id'],
                'bed_status_id'      => $value['bed_status_id'],
                'display_order'         => $value['display_order']
            ]);
        }
    }
}
