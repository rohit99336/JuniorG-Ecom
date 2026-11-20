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
            AdminSeeder::class,
            // Uncomment the seeders below if you want to import global country, state, and city SQL data:
            // CountrySeeder::class,
            // StateSeeder::class,
            // CitySeeder::class,
        ]);
    }
}
