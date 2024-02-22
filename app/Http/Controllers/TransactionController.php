<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class TransactionController extends Controller
{
    public function show(string $wallet_id, string $transaction_group_id)
    {
        $transaction = Transaction::where('group_id', $transaction_group_id)->get();

        return $transaction;
    }

    public function create(string $id)
    {
        $wallet = Wallet::findOrFail($id);

        return view('transactions.create', ['wallet' => $wallet]);
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

    public function destroy(string $transaction_id, string $group_id)
    {



        $transaction_group = Transaction::where('group_id', $group_id)->get();


        $transaction_group->map->delete();

        return back()->with('success', 'Transaction deleted');
    }

    public function mark(string $transaction_id, string $group_id)
    {

        $transaction_group = Transaction::where('group_id', $group_id)->get();


        $transaction_group->map->update(['is_fraudulent' => true]);
        $transaction_group->map->save();

        return back()->with('success', 'Marked as fraud');
    }
}
