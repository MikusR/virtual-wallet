<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets()
                       ->withCount(['transactions'])
                       ->withSum('transactions', 'amount')
                       ->latest()
                       ->get();

//        foreach ($wallets as $wallet) {
//            $wallet->balance = $wallet->transactions()->sum('amount');
//        }

        return view('wallets.index', ['wallets' => $wallets]);
    }

    public function show(string $id)
    {
        $wallet = Wallet::with('transactions')->findOrFail($id);

        return view('wallets.transactions', ['wallet' => $wallet]);
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

    public function update(string $id)
    {
        $wallet = Wallet::findOrFail($id);

        if (request()->input('name') === Wallet::findOrFail($id)->name) {
            return redirect(route('transactions', $wallet));
        }

        $attributes = request()->validate([
            'name' => [
                'required', 'max:255', 'min:3', 'required',
                Rule::unique('wallets')->where('user_id', Auth::user()->id),
            ]
        ]);

        $wallet->update($attributes);

        return redirect(route('transactions', $wallet))->with('success', 'Wallet renamed');
    }

    public function destroy(string $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return redirect('/wallets')->with('success', 'Wallet deleted');
    }

}
