<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Http\Resources\UserProfileResource;

class UserController extends Controller
{
    /**
     * @group Usuarios
     *
     * Obtener todos los usuarios
     *
     * Este endpoint recupera todos los usuarios con los campos seleccionados.
     *
     * @response 200 {
     *  "data": [
     *    {
     *      "name": "John Doe",
     *      "email": "john@example.com",
     *      "avatar": "avatar.jpg",
     *      "province": "Province",
     *      "address": "123 Street",
     *      "postal_code": "12345"
     *    }
     *  ]
     * }
     */
    public function index()
    {
        $users = User::select('name', 'email', 'avatar', 'province', 'address', 'postal_code')->get();

        return UsersResource::collection($users);
    }

    /**
     * @group Usuarios
     *
     * Obtener perfil de usuario
     *
     * Este endpoint recupera el perfil de un usuario específico por ID.
     *
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "email": "john@example.com",
     *    "avatar": "avatar.jpg",
     *    "province": "Province",
     *    "address": "123 Street",
     *    "postal_code": "12345",
     *    "phone_number": "123-456-7890",
     *    "products": [
     *      {
     *        "id": 1,
     *        "name": "Product 1",
     *        "description": "Description of product 1",
     *        "price": 1000
     *      }
     *    ],
     *    "comments": [
     *      {
     *        "id": 1,
     *        "content": "This is a comment",
     *        "created_at": "2023-01-01T00:00:00.000000Z"
     *      }
     *    ]
     *  }
     * }
     */
    public function show(User $user)
    {
        $profile = User::select('id','name', 'email', 'avatar', 'province', 'address', 'postal_code', 'phone_number')->where('id', $user->id)->get();
        $profile = $profile[0];
        $products = $user->products()->published()->get();

        $comments = $user->comments()->orderBy('created_at', 'desc')->get();

        return new UserProfileResource($profile, $products, $comments);
    }
}
