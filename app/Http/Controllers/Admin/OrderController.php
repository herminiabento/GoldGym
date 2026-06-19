<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);

        foreach ($orders as $order) {
            $order->total_price = $order->items->sum(fn($item) => $item->plan->price);
        }

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->total_price = $order->items->sum(fn($item) => $item->plan->price);
        return view('admin.orders.show', compact('order'));
    }
}
