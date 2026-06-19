<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        // inicio de sesión
        $credentials = $request->validate([
            'dni' => 'required|digits:8',
            'password' => 'required|string|min:6',
        ],[
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.digits' => 'El campo DNI debe tener exactamente 8 dígitos.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres.',
        ]);

        $recuerdame = $request->boolean('rememberMe', false);

        if (Auth::attempt(['dni' => $request->dni, 'password' => $request->password], $recuerdame)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role?->type) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'user':
                    return redirect()->route('user.dashboard');
                default:
                    return redirect()->route('home');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'dni' => 'Las credenciales proporcionadas no son correctas.',
        ])->onlyInput('dni');
    }

    public function logout(Request $request)
    {
        // cierre de sesión
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $defaultRole = Role::where('type', 'user')->first();

        // registro de usuario
        $data = $request->validate([
            'dni' => 'required|size:8|unique:users,dni',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            //'password' => 'required|string|min:6|confirmed',
            'password' => 'required|string|min:6',
            'term' => 'accepted',

        ], [
            'term.accepted' => 'Debes aceptar los términos y condiciones para registrarte.',
            'dni.unique' => 'El DNI ya está registrado en el sistema.',
            'email.unique' => 'El email ya está registrado en el sistema.',
            'name.required' => 'El nombre es obligatorio.',
            'lastname.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.size' => 'El DNI debe tener exactamente 8 dígitos.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección válida.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres.',
        ]);

        User::create([
            'dni' => $data['dni'],
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $defaultRole->id
        ]);

        return redirect()->route('auth.login')->with('success', 'Registro exitoso. ¡Bienvenido a Gold Gym!. Ingresá al sistema para empezar a entrenar');
    }

}
