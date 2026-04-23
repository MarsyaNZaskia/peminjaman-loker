<?php

namespace Database\Seeders;

use Database\Seeders\AdminSeeder;
use Database\Seeders\BukuSeeder;
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
        KategoriSeeder::class,
        AdminSeeder::class,
        BukuSeeder::class,
        SettingSeeder::class,
    ]);
    }
}
