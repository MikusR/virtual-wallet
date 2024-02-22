<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function create(): View
    {
        return view('login');
    }

    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'email' => ['required', 'max:255', 'min:3', 'email'],
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

    public function destroy(): RedirectResponse
    {
        auth()->logout();

        return redirect('/')->with('success', 'User logged out');
    }
}
