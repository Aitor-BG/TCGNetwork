<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación con los campos 'name', 'username', 'email', 'role' y 'password'
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username'=> ['required', 'string', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', 'in:tienda,usuario'],  // Asegura que el role sea uno de los dos valores
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear el usuario con los campos name, username, email, role y password
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,  // Guardar el 'username'
            'email' => $request->email,
            'role' => $request->role,  // Guardar el 'role'
            'password' => Hash::make($request->password),
        ]);

        // Disparar el evento de registro
        event(new Registered($user));

        // Loguear al usuario recién registrado
        Auth::login($user);

        if($user->role==='tienda'){
            return redirect('tienda/dashboard');
        }elseif ($user->role==='usuario') {
            return redirect('usuario/dashboard');
        }
    }
}
