<?php

namespace App\Http\Controllers;

use App\Models\Wallet;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function index(): View
    {
        $wallets = Auth::user()->wallets()
            ->withCount(['transactions'])
            ->withSum('transactions', 'amount')
            ->latest()
            ->get();

        return view('wallets.index', ['wallets' => $wallets]);
    }

    public function show(string $id): View
    {
        $wallet = Wallet::with('transactions')->findOrFail($id);

        return view('wallets.transactions', ['wallet' => $wallet]);
    }

    public function create(): View
    {
        return view('wallets.create');
    }

    public function store(): RedirectResponse
    {
        $attributes = request()->validate([
            'name' => [
                'required', 'max:255', 'min:3', 'required',
                Rule::unique('wallets')->where('user_id', Auth::user()->id),
            ]
        ]);
        request()->user()->wallets()->create($attributes);

        return redirect('/wallets')->with('success', 'Wallet created');
    }

    public function update(string $id): RedirectResponse
    {
        $wallet = Wallet::findOrFail($id);

        if (request()->input('name') === Wallet::findOrFail($id)->name) {
            return redirect(route('transactions', $wallet));
        }

        $attributes = Validator::make(request()->all(), [
            'name' => [
                'max:255', 'min:3', 'required',
                Rule::unique('wallets')->where('user_id', Auth::user()->id),
            ]
        ])->validate();

        $wallet->update($attributes);

        return redirect(route('transactions', $wallet))->with('success', 'Wallet renamed');
    }

    public function destroy(string $id): RedirectResponse
    {
        $wallet = Wallet::findOrFail($id);

        $wallet->delete();

        return redirect('/wallets')->with('success', 'Wallet deleted');
    }

}
