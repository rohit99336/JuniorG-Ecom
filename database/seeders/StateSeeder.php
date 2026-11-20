<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $path = public_path('sql/states.sql');
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
