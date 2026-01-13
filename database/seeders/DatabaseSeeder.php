<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // TagihanSeeder::class, // (If exists)
            // PembayaranSeeder::class, // (If exists)
            // HafalanSeeder::class, // (If exists)
            ThreadSeeder::class,
            UnitUsahaSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
