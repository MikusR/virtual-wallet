<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets()->get();


        return view('wallets.index', ['wallets' => $wallets]);
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => [
                'required', 'max:255', 'min:3', 'required',
                Rule::unique('wallets')->where('user_id', Auth::user()->id),
            ]
        ]);
        request()->user()->wallets()->create($attributes);

        //'unique:wallets,name,user_id,'.Auth::user()->id
        return redirect('/wallets')->with('success', 'Wallet created');
    }


}
