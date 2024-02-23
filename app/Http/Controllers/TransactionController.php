<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Rules\HasEnoughBalance;
use Illuminate\Http\RedirectResponse;
use Validator;
use Illuminate\View\View;


class TransactionController extends Controller
{
    public function show(string $wallet_id, string $transaction_group_id)
    {
        $transaction = Transaction::where('group_id', $transaction_group_id)->get();

        return $transaction;
    }

    public function create(string $id): View
    {
        $wallet = Wallet::findOrFail($id);

        return view('transactions.create', ['wallet' => $wallet]);
    }

    public function store(): RedirectResponse
    {
        $attributes = Validator::make(request()->all(), [
            'from' => ['required', 'integer', 'exists:wallets,id', 'different:to'],
            'to' => ['required', 'integer', 'exists:wallets,id', 'different:from'],
            'amount' => ['required', 'integer', 'gt:0', new HasEnoughBalance()],
        ], $messages = [
            'different' => "Can't send inside same wallet!",
        ])->validate();

        $from = Transaction::create([
            'wallet_id' => $attributes['from'],
            'amount' => -$attributes['amount'],
            'type' => 'out',
        ]);

        $groupId = $from->id;
        $from->group_id = $groupId;
        $from->save();

        $to = Transaction::create([
            'wallet_id' => $attributes['to'],
            'amount' => $attributes['amount'],
            'type' => 'in',
            'group_id' => $groupId
        ]);
        $to->save();

        return redirect(route('transactions', $from->wallet_id))->with('success', 'Transaction created');
    }

    public function destroy(string $transaction_id, string $group_id): RedirectResponse
    {
        $transaction_group = Transaction::where('group_id', $group_id)->get();
        $transaction_group->map->delete();

        return back()->with('success', 'Transaction deleted');
    }

    public function mark(string $transaction_id, string $group_id): RedirectResponse
    {
        $transaction_group = Transaction::where('group_id', $group_id)->get();
        $transaction_group->map->update(['is_fraudulent' => true]);
        $transaction_group->map->save();

        return back()->with('success', 'Marked as fraud');
    }
}
