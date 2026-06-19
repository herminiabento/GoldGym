<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Traigo los últimos 5 planes
        $latestPlans = Plan::orderBy('created_at', 'desc')->take(5)->get();

        // Traigo los últimos 5 usuarios
        $latestUsers = User::with('role','plans')->orderBy('created_at', 'desc')->take(5)->get();

        // Traigo las últimas 5 categorías
        $latestCategories = Category::orderBy('created_at', 'desc')->take(5)->get();

        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        // Datos del usuario actual
        $currentUser = Auth::user();

        // Opcional: obtener el plan activo del usuario
        //$currentPlan = $currentUser->plans()->where('active', true)->first(); // depende de la relación

        return view('admin.index', compact(
            'latestPlans',
            'latestUsers',
            'latestCategories',
            'currentUser',
            'latestOrders'
            //'currentPlan'
        ));
    }
}
