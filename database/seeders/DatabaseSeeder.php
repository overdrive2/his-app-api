<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            OccuIpdStaffSeeder::class,
            OccuOpdStaffSeeder::class,
            OccuIpdTypeSeeder::class,
            OccuStatusSeeder::class,
            RoomTypeSeeder::class,
            BedStatusSeeder::class,
            IpdBedmoveTypeSeeder::class,
            DietSeeder::class,
            PttypePriceGroupSeeder::class,
            DchTypeSeeder::class,
            DchStatusSeeder::class,
            IpdDoctorTypeSeeder::class,
            IpdSevereSeeder::class,
          //  HisIpdNewcaseSeeder::class,
            IpdAdmitTypeSeeder::class,
          //  HisIpdSeeder::class,
            // IpdFormAsmSeeder::class,
            DrugItemsSeeder::class,
            WardSeeder::class,
            RoomSeeder::class,
            BedSeeder::class
        ]);
    }
}
