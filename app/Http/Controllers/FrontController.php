<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        $plans = Plan::orderBy('created_at', 'desc')->take(4)->get();
        return view('home', compact('plans'));
    }

    public function plans()
    {
        $plans = Plan::orderBy('created_at', 'desc')->get();
        return view('plans', compact('plans'));
    }

    public function planShow(Plan $plan)
    {
        $plans = Plan::where('id', '!=', $plan->id)->orderBy('created_at', 'desc')->take(4)->get();
        return view('plans-show', compact('plan', 'plans'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
