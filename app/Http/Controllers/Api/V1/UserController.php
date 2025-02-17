<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Http\Resources\UserProfileResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'avatar', 'province', 'address', 'postal_code')->get();

        return UsersResource::collection($users);
    }

    public function show(User $user)
    {
        $profile = User::select('id','name', 'email', 'avatar', 'province', 'address', 'postal_code', 'phone_number')->where('id', $user->id)->get();
        $profile = $profile[0];
        $products = $user->products()->published()->get();

        $comments = $user->comments()->orderBy('created_at', 'desc')->get();

        return new UserProfileResource($profile, $products, $comments);
    }
}
