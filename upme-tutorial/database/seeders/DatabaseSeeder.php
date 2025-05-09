<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create admin user
        User::create([
            'first_name' => 'Admin',
            'middle_name' => 'admin',
            'last_name' => 'admin',
            'cellphone_num' => '+6391231234',
            'email' => 'admin@admin.com',
            'address' => 'Manila, Philippines',
            'department' => 'Product and Technology',
            'position' => 'Admin',
            'status' => 'Active',
            'remember_token'    => Str::random(10),
            'avatar'            => 'avatars/default.jpg',
            'date_hired'        => now(),
            'email_verified_at' => now(),

            'password' => Hash::make('asdf'), 
            'status' => 'Active',
            'is_admin' => true, 
        ]);

        User::factory(30)->create();
    }
}
