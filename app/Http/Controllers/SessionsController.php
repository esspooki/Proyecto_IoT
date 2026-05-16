<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        //Función para mostrar la vista de inicio de sesión, se retorna la vista correspondiente.
        return view('session.login-session');
    }

    public function store(Request $request)
    {
        //Función para manejar el proceso de inicio de sesión, se validan las credenciales ingresadas, se intenta iniciar sesión y se redirige al dashboard con un mensaje de éxito o se regresa con un error si las credenciales son incorrectas.
        $attributes = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                    'max:255'
                ],
                'password' => [
                    'required',
                    'min:6',
                    'max:32',
                    'regex:/^[A-Za-z0-9@#\$%\^&\*\-\_]+$/'
                ]
            ],
            [
                'email.required' => 'El campo correo electrónico es obligatorio.',
                'email.email' => 'Por favor ingresa un correo electrónico válido.',
                'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.max' => 'La contraseña no puede tener más de 32 caracteres.',
                'password.regex' => 'La contraseña contiene caracteres no permitidos.',
            ]
        );

        $remember = $request->filled('remember');

        if (Auth::attempt($attributes, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with(['success' => 'Has iniciado sesión correctamente.']);
        }

        // Si las credenciales son inválidas
        return back()->withErrors(['email' => 'El correo electrónico o la contraseña son incorrectos.',])->onlyInput('email', 'remember');
    }

    public function destroy(Request $request)
    {
        //Función para manejar el proceso de cierre de sesión, se cierra la sesión, se invalida la sesión actual y se regenera el token CSRF, luego se redirige al login con un mensaje de éxito.
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with(['success' => 'Has cerrado sesión correctamente.']);
    }
}
