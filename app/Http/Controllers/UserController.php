<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:6','confirmed'],
            'register_code' => ['required'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación no coincide.',
            'register_code.required' => 'El código de registro es obligatorio.',
        ]);

        // ✅ Código secreto en .env
        if ($request->register_code !== env('REGISTER_CODE')) {
            return back()->withErrors(['register_code' => 'Código de registro incorrecto.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Rol por defecto
        $user->assignRole('Consulta');

        return redirect()->route('login')->with('status', 'Cuenta creada. Ya puedes iniciar sesión.');
    }
}