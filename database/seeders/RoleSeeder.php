<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         $roles = [
            [
                'type' => 'admin',
                'name' => 'Administrador',
            ],
            [
                'type' => 'user',
                'name' => 'Usuario',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
