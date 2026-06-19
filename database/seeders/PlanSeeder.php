<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plans = [
            [
                'title' => 'Musculación',
                'duration' => 'mensual',
                'price' => 40000,
                'status' => 1,
                'excerpt' => 'Plan básico de musculación.',
                'description' => 'Entrenamiento de musculación grupal.',
                'categories' => ['msc'],
            ],
            [
                'title' => 'Musculación Full',
                'duration' => 'anual',
                'price' => 440000,
                'status' => 1,
                'excerpt' => 'Abono anual de musculación.',
                'description' => 'Incluye acceso a todas las máquinas.',
                'categories' => ['msc'],
            ],
            [
                'title' => 'Pilates Simple',
                'duration' => 'mensual',
                'price' => 23000,
                'status' => 1,
                'excerpt' => 'Plan mensual de pilates 1 clase por semana.',
                'description' => '1 clase por semana de pilates básico, enfocada en la flexibilidad y postura.',
                'categories' => ['plt'],
            ],
            [
                'title' => 'Pilates Clásico',
                'duration' => 'mensual',
                'price' => 28000,
                'status' => 1,
                'excerpt' => 'Plan clásico de pilates 2 veces por semana.',
                'description' => '2 clases por semana de pilates clásicas.',
                'categories' => ['plt'],
            ],
            [
                'title' => 'Pilates Full',
                'duration' => 'mensual',
                'price' => 39000,
                'status' => 1,
                'excerpt' => 'Plan de 3 clases por semana de pilates.',
                'description' => '3 clases por semana de pilates en reformer.',
                'categories' => ['plt'],
            ],
            [
                'title' => 'Strong Simple',
                'duration' => 'mensual',
                'price' => 20000,
                'status' => 1,
                'excerpt' => 'Plan básico de 1 clases por semana.',
                'description' => '1 clases por semana de entrenamiento de fuerza general con rutinas adaptadas para principiantes',
                'categories' => ['ftn'],
            ],
            [
                'title' => 'Strong Clásico',
                'duration' => 'mensual',
                'price' => 22000,
                'status' => 0,
                'excerpt' => 'Plan de 2 clases por semana.',
                'description' => '2 clases por semana de entrenamiento de fuerza general con rutinas adaptadas.',
                'categories' => ['ftn'],
            ],
            [
                'title' => 'Strong Full',
                'duration' => 'mensual',
                'price' => 25000,
                'status' => 1,
                'excerpt' => 'Plan full de 3 clases por semana.',
                'description' => '3 clases por semana. Ideal para mejorar fuerza, resistencia y tonificación muscular.',
                'categories' => ['ftn'],
            ],
            [
                'title' => 'Un día de Gym',
                'duration' => 'unico',
                'price' => 5000,
                'status' => 1,
                'excerpt' => 'Pase por un día de entrenamiento.',
                'description' => 'Un pase único válido por un día de entrenamiento con acceso a todas las maquinas asistido por profe del gym. O a una de nuestras clases de pilates o strong. Ideal para venir y conocernos.',
                'categories' => ['ftn','plt','msc'],
            ],

        ];

        foreach ($plans as $plan) {
            $categories = $plan['categories'];
            unset($plan['categories']);

            $newPlan = Plan::create($plan);

            $categoryIds = Category::whereIn('code', $categories)->pluck('id');
            $newPlan->categories()->sync($categoryIds);
        }
    }
}
