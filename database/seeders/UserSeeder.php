<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'dni' => '00000001',
                'name' => 'Administrador',
                'lastname' => 'Principal',
                'email' => 'admin@goldgym.com',
                'password' => bcrypt('123456'),
                'role_id' => 1,
            ],
            [
                'dni' => '26293564',
                'name' => 'Paola',
                'lastname' => 'Zarate',
                'email' => 'paolazarate@gmail.com',
                'password' => bcrypt('123456'),
                'role_id' => 2,
            ],
            [
                'dni' => '27294563',
                'name' => 'Martin',
                'lastname' => 'Peralta',
                'email' => 'mperalta@gmail.com',
                'password' => bcrypt('123456'),
                'role_id' => 2,
            ]
        ];
        foreach ($users as $user) {
            $user = User::create($user);
        }
    }
}
