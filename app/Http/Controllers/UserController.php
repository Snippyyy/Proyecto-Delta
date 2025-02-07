<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'email', 'avatar', 'province', 'address', 'postal_code')->get();

        return view('users.user-index', compact('users'));
    }

    public function show(User $user)
    {
        $profile = User::select('id','name', 'email', 'avatar', 'province', 'address', 'postal_code', 'phone_number')->where('id', $user->id)->get();
        $profile = $profile[0];
        $products = $user->products()->where('status', 'published')->get();

        $comments = $user->comments()->orderBy('created_at', 'desc')->get();

        return view('users.user-profile', compact('profile', 'products', 'comments'));
    }
}
