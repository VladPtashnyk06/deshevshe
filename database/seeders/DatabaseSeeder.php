<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DeliveryMethod;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
             'name' => 'Admin',
             'last_name' => 'Admin',
             'phone' => '0971037978',
             'email' => 'Admin@gmail.com',
             'role' => 'Admin',
             'password' => \Hash::make('admin'),
         ]);
        \App\Models\User::factory()->create([
             'name' => 'User',
             'last_name' => 'User',
             'phone' => '0000000000',
             'email' => 'User@gmail.com',
             'password' => \Hash::make('user'),
         ]);
    }
}
