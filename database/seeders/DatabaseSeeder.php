<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\IpdBedmoveType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            IpdNurseShiftSeeder::class,
            IpdOccuTypeSeeder::class,
            OccuStaffSeeder::class,
            OccuStatusSeeder::class,
            RoomTypeSeeder::class,
            BedStatusSeeder::class,
            IpdBedmoveType::class
        ]);
    }
}
