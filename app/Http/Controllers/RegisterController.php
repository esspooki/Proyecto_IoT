<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        //Función para mostrar la vista de registro, se retorna la vista correspondiente.
        return view('session.register');
    }

    public function store()
    {
        //Función para registrar un nuevo usuario, se validan los datos ingresados, se crea el usuario en la base de datos, se inicia sesión automáticamente y se redirige al dashboard con un mensaje de éxito.
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'agreement' => ['accepted']
        ]);
        $attributes['password'] = bcrypt($attributes['password'] );

        

        session()->flash('success', 'Your account has been created.');
        $user = User::create($attributes);
        Auth::login($user); 
        return redirect('/dashboard');
    }
}
