<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@email.com',
            'phone_number' => '09568475424',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }
}
