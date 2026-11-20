<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $path = public_path('sql/cities.sql');
            $sql = file_get_contents($path);
            DB::unprepared($sql);

            // $sql = file($path);
            // // $chunks = array_chunk($sql, 1000);
            // // foreach ($chunks as $chunk) {
            // //     $query = implode("", $chunk);
            // //     DB::unprepared($query);
            // // }

            // // seed data in City table from cities.sql using Model
            // foreach ($sql as $query) {
            //     $query = trim($query);
            //     if ($query) {
            //         City::insert([
            //             'id' => substr($query, 0, strpos($query, ',')),
            //             'name' => substr($query, strpos($query, ',') + 1, strrpos($query, ',') - strpos($query, ',') - 1),
            //             'state_id' => substr($query, strrpos($query, ',') + 1),
            //         ]);
            //     }
            // }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
