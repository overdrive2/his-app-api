<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::truncate();

        $json = json_decode(file_get_contents("database/data/rooms.json"), true);

        foreach ($json as $value) {
            Room::create([
                'id'             => $value['id'],
                'room_name'           => $value['room_name'],
                'room_type_id'      => $value['room_type_id'],
                'ward_id'      => $value['ward_id'],
                'display_order'         => $value['display_order']
            ]);
        }
    }
}
