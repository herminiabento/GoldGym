<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ['code' => 'msc', 'name' => 'Musculación'],
            ['code' => 'plt', 'name' => 'Pilates'],
            ['code' => 'ftn', 'name' => 'Fitness']
        ];

        DB::table('categories')->insert($categories);
    }
}
