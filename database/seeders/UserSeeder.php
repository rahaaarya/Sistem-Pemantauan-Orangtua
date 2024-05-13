<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('123456')
            ],
            [
                'name' => 'dosen',
                'email' => 'dosen@example.com',
                'role' => 'dosen',
                'password' => Hash::make('123456')
            ],
            [
                'name' => 'user',
                'email' => 'user@example.com',
                'role' => 'user',
                'password' => Hash::make('123456')
            ],

        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
