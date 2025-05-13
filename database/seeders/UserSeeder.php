<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gebmoll.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'docente@gebmoll.com'],
            [
                'name' => 'Docente',
                'password' => Hash::make('password'),
                'role' => 'docente'
            ]
        );

        User::updateOrCreate(
            ['email' => 'alumno@gebmoll.com'],
            [
                'name' => 'Alumno',
                'password' => Hash::make('password'),
                'role' => 'alumno'
            ]
        );
    }
}
