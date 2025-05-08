<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create admin user
        // User::create([
        //     'first_name' => 'Admin',
        //     'last_name' => 'User',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'), 
        //     'status' => 'Active',
        //     'is_admin' => true, 
        //     // Add any other necessary fields here
        // ]);
    

        User::factory(30)->create();
    }
}
