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
        \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'administrator',
            'password' => bcrypt('password'),
            'role' => 'SUPER-ADMIN'
        ]);

        $this->call([
            WilayahSeeder::class,
            MaterialSeeder::class
        ]);
    }
}
    