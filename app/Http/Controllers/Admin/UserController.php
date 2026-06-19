<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::with('plans')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        $user->load('plans');

        $orders = $user->orders()->orderBy('created_at', 'desc')->with('items.plan')->paginate(10);

        $orders->getCollection()->each(function ($order) {
            $order->items = $order->items
                ->filter(fn ($item) => $item->plan && $item->plan->status == 1);

            $order->total_price = $order->items
                ->sum(fn ($item) => $item->plan->price * ($item->quantity ?? 1));
        });

        $totalPrice = $user->plans->sum('price');
        return view('admin.users.show', compact('user', 'totalPrice','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        $totalPrice = $user->plans->sum('price');

        return view('admin.users.edit', compact('user', 'roles', 'totalPrice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $rules = [
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'role_id' => 'required|exists:roles,id',
            'dni' => ['required', 'digits:8', Rule::unique('users','dni')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)]
        ];

        $validatedUser = $request->validate($rules, [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ya existe.',
            'dni.max' => 'El DNI no puede superar los 10 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 50 caracteres.',
            'lastname.required' => 'El apellido es obligatorio.',
            'lastname.max' => 'El apellido no puede superar los 50 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe ser una dirección válida.',
            'email.unique' => 'El email ya existe.',
        ]);

        $user->update($validatedUser);
        return redirect()->route('admin.users.index')->with('success', 'El usuario fue actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'El usuario fue eliminado exitosamente.');
    }

    public function removeMembership(User $user, $planId)
    {
        if (!$user->plans()->where('plans.id', $planId)->exists()) {
            return back()->with('error', 'El usuario no tiene este plan asignado.');
        }

        // Eliminar la membresía de la tabla pivote
        $user->plans()->detach($planId);

        return redirect()->route('admin.users.index')->with('success', 'El plan fue cancelado correctamente.');
    }

}
