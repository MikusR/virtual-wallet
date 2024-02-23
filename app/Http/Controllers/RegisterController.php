<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('register.create');
    }

    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'min:3', 'email', 'unique:users,email'],
            'password' => ['required', 'max:255', 'min:3']
        ]);
        $attributes['password'] = bcrypt($attributes['password']);

        $user = User::create($attributes);

        auth()->login($user);

        return redirect('/wallets')->with('success', "Account {$attributes['name']} has been created");
    }
}
