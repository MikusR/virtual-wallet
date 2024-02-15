<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email'    => ['required', 'max:255', 'min:3', 'email'],
            'password' => ['required', 'max:255', 'min:3']
        ]);
        if (auth()->attempt($attributes)) {
            session()->regenerate();

            return redirect('/wallets')->with('success', 'Welcome back');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => 'Wrong credentials']);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/')->with('success', 'User logged out');
    }
}
