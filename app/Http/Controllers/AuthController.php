<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. FUNCIÓN PARA REGISTRARSE
    public function register(Request $request)
    {
        // Comprobamos que nos envían todos los datos correctamente
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Creamos el usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptamos la contraseña por seguridad
            'rol' => 'usuario' // Le ponemos el rol por defecto que acordaste con el profe
        ]);

        return response()->json(['mensaje' => 'Usuario registrado con éxito'], 201);
    }

    // 2. FUNCIÓN PARA INICIAR SESIÓN (LOGIN)
    public function login(Request $request)
    {
        // Pedimos el email y la contraseña
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscamos al usuario en la base de datos
        $user = User::where('email', $request->email)->first();

        // Si no existe o la contraseña está mal, damos error
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['mensaje' => 'Credenciales incorrectas'], 401);
        }

        //Creamos el Token de seguridad
        $token = $user->createToken('auth_token')->plainTextToken;

        // Devolvemos el token y los datos del usuario para que Vue los use
        return response()->json([
            'mensaje' => 'Login correcto',
            'access_token' => $token,
            'usuario' => $user
        ]);
    }
}