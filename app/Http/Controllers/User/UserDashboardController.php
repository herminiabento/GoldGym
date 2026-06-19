<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    // Dashboard
    public function index()
    {
        $currentUser = Auth::user()->load([
            'plans',
            'orders' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'orders.items.plan'
        ]);

        $lastOrder = $currentUser->orders->first();

        if ($lastOrder) {
            $lastOrder->items = $lastOrder->items
                ->filter(fn($item) => $item->plan->status == 1);

            $lastOrder->total_price = $lastOrder->items
                ->sum(fn($item) => $item->plan->price * ($item->quantity ?? 1));
        }

        return view('user.index', compact('currentUser','lastOrder'));
    }

}
