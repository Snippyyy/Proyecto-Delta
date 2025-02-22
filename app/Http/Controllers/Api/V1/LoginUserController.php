<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;

class LoginUserController extends Controller
{

    /**
     * @group Autenticación
     *
     * Iniciar sesión
     *
     * Este endpoint permite a un usuario iniciar sesión y obtener un token de autenticación.
     *
     * @bodyParam email string required El correo electrónico del usuario. Ejemplo: "usuario@example.com"
     * @bodyParam password string required La contraseña del usuario. Ejemplo: "password123"
     *
     * @response 200 {
     *  "token": "string"
     * }
     * @response 401 {
     *  "message": "Unauthorized"
     * }
     */
    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();

        if (!auth()->attempt($validated)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = auth()->user()->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
