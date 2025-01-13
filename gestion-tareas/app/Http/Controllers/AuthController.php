<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|integer|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|integer|in:0,1',
        ]);

        $user = User::create([
            'dni' => $validated['dni'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => $validated['rol'],
        ]);

        $roleName = $validated['rol'] === 0 ? 'user_admin' : 'user_standard';
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id
        ]);

        $user->save();
        return response()->json(['message' => 'Usuario registrado con éxito'], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($data)) {
            $user = Auth::user(); // Obtener el usuario autenticado
            $token = $user->createToken('main')->plainTextToken; // Generar el token
            $roles = $user->roles->pluck('name'); // Obtener los roles del usuario

            return response()->json([
                'user' => [
                    'id' => $user->id,
                    'dni' => $user->dni,
                    'email' => $user->email,
                    'roles' => $roles,
                ],
                'token' => $token,
            ]);
        }

        // Si las credenciales no son válidas
        return response()->json([
            'message' => 'Email o contraseña incorrectos',
        ], 401);
    }

    public function getAuthenticatedUser()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        return response()->json([
            'id' => $user->id,
            'dni' => $user->dni,
            'email' => $user->email,
            'name' => $user->name ?? 'Usuario', // Ajusta según tus columnas
            'roles' => $user->roles->pluck('name'),
        ]);
    }
}
