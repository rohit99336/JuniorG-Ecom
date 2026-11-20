<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\EcomAdmin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // EcomAdmin::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('password'),
        // ]);

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('password'),
        // ]);


        // create 5 dummy users
        $users = $users = [
            [
                "name" => "admin",
                "email" => "admin@admin.com",
                "password" => bcrypt('password')  // Hash the password using bcrypt
            ],
            [
                "name" => "rohit",
                "email" => "rohit@admin.com",
                "password" => bcrypt('password')
            ],
            [
                "name" => "prince",
                "email" => "prince@admin.com",
                "password" => bcrypt('password')
            ],[
                "name" => "shailendra",
                "email" => "shailendra@admin.com",
                "password" => bcrypt('password')
            ]
        ];

        // store the users in the database
        foreach ($users as $user) {
            //  User::create($user);
             EcomAdmin::create($user);
        }

        // $json_users = json_encode($users); // Convert array to JSON string

    }
}
